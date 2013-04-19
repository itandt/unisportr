<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ITT\Mvc\Router\Http;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Mvc\Router\Http\Segment as ZendSegment;
use Zend\Mvc\Router\Http\RouteMatch;

class UnicodeSegment extends ZendSegment
{
    protected function parseRouteDefinition($def)
    {
        $currentPos = 0;
        $length     = strlen($def);
        $parts      = array();
        $levelParts = array(&$parts);
        $level      = 0;

        while ($currentPos < $length) {
            preg_match('((\G(?P<literal>[^:{\[\]]*)(?P<token>[:{\[\]]|$)))u', $def, $matches, 0, $currentPos);

            $currentPos += strlen($matches[0]);

            if (!empty($matches['literal'])) {
                $levelParts[$level][] = array('literal', $matches['literal']);
            }

            if ($matches['token'] === ':') {
                if (isset($def[$currentPos]) && $def[$currentPos] === '{') {
                    if (!preg_match('(\G\{(?P<name>[^}]+)\}:?)u', $def, $matches, 0, $currentPos)) {
                        throw new Exception\RuntimeException('Translated parameter missing closing bracket');
                    }

                    $levelParts[$level][] = array('translated-parameter', $matches['name']);
                } else {
                    if (!preg_match('((\G(?P<name>[^:/{\[\]]+)(?:{(?P<delimiters>[^}]+)})?:?))u', $def, $matches, 0, $currentPos)) {
                        throw new Exception\RuntimeException('Found empty parameter name');
                    }

                    $levelParts[$level][] = array('parameter', $matches['name'], isset($matches['delimiters']) ? $matches['delimiters'] : null);
                }

                $currentPos += strlen($matches[0]);
            } elseif ($matches['token'] === '{') {
                if (!preg_match('(\G(?P<literal>[^}]+)\})u', $def, $matches, 0, $currentPos)) {
                    throw new Exception\RuntimeException('Translated literal missing closing bracket');
                }

                $currentPos += strlen($matches[0]);

                $levelParts[$level][] = array('translated-literal', $matches['literal']);
            } elseif ($matches['token'] === '[') {
                $levelParts[$level][] = array('optional', array());
                $levelParts[$level + 1] = &$levelParts[$level][count($levelParts[$level]) - 1][1];

                $level++;
            } elseif ($matches['token'] === ']') {
                unset($levelParts[$level]);
                $level--;

                if ($level < 0) {
                    throw new Exception\RuntimeException('Found closing bracket without matching opening bracket');
                }
            } else {
                break;
            }
        }

        if ($level > 0) {
            throw new Exception\RuntimeException('Found unbalanced brackets');
        }

        return $parts;
    }

    /**
     * Build the matching regex from parsed parts.
     *
     * @param  array   $parts
     * @param  array   $constraints
     * @param  integer $groupIndex
     * @return string
     * @throws Exception\RuntimeException
     */
    protected function buildRegex(array $parts, array $constraints, &$groupIndex = 1)
    {
        $regex = '';

        foreach ($parts as $part) {
            switch ($part[0]) {
                case 'literal':
                    $regex .= preg_quote($part[1]);
                    break;

                case 'parameter':
                    $groupName = '?P<param' . $groupIndex . '>';

                    if (isset($constraints[$part[1]])) {
                        $regex .= '(' . $groupName . $constraints[$part[1]] . ')';
                    } elseif ($part[2] === null) {
                        $regex .= '(' . $groupName . '[^/]+)';
                    } else {
                        $regex .= '(' . $groupName . '[^' . $part[2] . ']+)';
                    }

                    $this->paramMap['param' . $groupIndex++] = $part[1];
                    break;

                case 'optional':
                    $regex .= '(?:' . $this->buildRegex($part[1], $constraints, $groupIndex) . ')?';
                    break;

                // @codeCoverageIgnoreStart
                case 'translated-literal':
                    throw new Exception\RuntimeException('Translated literals are not implemented yet');
                    break;

                case 'translated-parameter':
                    throw new Exception\RuntimeException('Translated parameters are not implemented yet');
                    break;
                // @codeCoverageIgnoreEnd
            }
        }

        return $regex;
    }

    /**
     * Build a path.
     *
     * @param  array   $parts
     * @param  array   $mergedParams
     * @param  bool $isOptional
     * @param  bool $hasChild
     * @return string
     * @throws Exception\RuntimeException
     * @throws Exception\InvalidArgumentException
     */
    protected function buildPath(array $parts, array $mergedParams, $isOptional, $hasChild)
    {
        $path      = '';
        $skip      = true;
        $skippable = false;

        foreach ($parts as $part) {
            switch ($part[0]) {
                case 'literal':
                    $path .= $part[1];
                    break;

                case 'parameter':
                    $skippable = true;

                    if (!isset($mergedParams[$part[1]])) {
                        if (!$isOptional || $hasChild) {
                            throw new Exception\InvalidArgumentException(sprintf('Missing parameter "%s"', $part[1]));
                        }

                        return '';
                    } elseif (!$isOptional || $hasChild || !isset($this->defaults[$part[1]]) || $this->defaults[$part[1]] !== $mergedParams[$part[1]]) {
                        $skip = false;
                    }

                    $path .= $this->encode($mergedParams[$part[1]]);

                    $this->assembledParams[] = $part[1];
                    break;

                case 'optional':
                    $skippable    = true;
                    $optionalPart = $this->buildPath($part[1], $mergedParams, true, $hasChild);

                    if ($optionalPart !== '') {
                        $path .= $optionalPart;
                        $skip  = false;
                    }
                    break;

                // @codeCoverageIgnoreStart
                case 'translated-literal':
                    throw new Exception\RuntimeException('Translated literals are not implemented yet');
                    break;

                case 'translated-parameter':
                    throw new Exception\RuntimeException('Translated parameters are not implemented yet');
                    break;
                // @codeCoverageIgnoreEnd
            }
        }

        if ($isOptional && $skippable && $skip) {
            return '';
        }

        return $path;
    }

    /**
     * match(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::match()
     * @param  Request $request
     * @param  string|null $pathOffset
     * @return RouteMatch
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $uri  = $request->getUri();
        $path = $uri->getPath();

        if ($pathOffset !== null) {
            $result = preg_match('(\G' . $this->regex . ')u', $path, $matches, null, $pathOffset);
        } else {
            $result = preg_match('(^' . $this->regex . '$)u', $path, $matches);
        }

        if (!$result) {
            return null;
        }

        $matchedLength = strlen($matches[0]);
        $params        = array();

        foreach ($this->paramMap as $index => $name) {
            if (isset($matches[$index]) && $matches[$index] !== '') {
                $params[$name] = $this->decode($matches[$index]);
            }
        }

        return new RouteMatch(array_merge($this->defaults, $params), $matchedLength);
    }

    /**
     * assemble(): Defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::assemble()
     * @param  array $params
     * @param  array $options
     * @return mixed
     */
    public function assemble(array $params = array(), array $options = array())
    {
        $this->assembledParams = array();

        return $this->buildPath(
            $this->parts,
            array_merge($this->defaults, $params),
            false,
            (isset($options['has_child']) ? $options['has_child'] : false)
        );
    }

    /**
     * getAssembledParams(): defined by RouteInterface interface.
     *
     * @see    RouteInterface::getAssembledParams
     * @return array
     */
    public function getAssembledParams()
    {
        return $this->assembledParams;
    }

    /**
     * Encode a path segment.
     *
     * @param string $value
     * @return string
     */
    protected function encode($value)
    {
        if (!isset(static::$cacheEncode[$value])) {
            static::$cacheEncode[$value] = rawurlencode($value);
            static::$cacheEncode[$value] = strtr(static::$cacheEncode[$value], static::$urlencodeCorrectionMap);
        }
        return static::$cacheEncode[$value];
    }

    /**
     * Decode a path segment.
     *
     * @param string $value
     * @return string
     */
    protected function decode($value)
    {
        return rawurldecode($value);
    }
}
