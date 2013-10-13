<?php
namespace ITT\Mvc\Router\Http;

use Zend\Mvc\Router\Http\Regex as ZendRegex;
use Zend\Stdlib\RequestInterface;
use Zend\Mvc\Router\Http\RouteMatch;

class Regex extends ZendRegex
{
	public function match(RequestInterface $request, $pathOffset = null)
	{
		if (!method_exists($request, 'getUri')) {
			return null;
		}
	
		$uri  = $request->getUri();
		$path = $uri->getPath();
	
		if ($pathOffset !== null) {
			$result = preg_match('(\G' . $this->regex . ')', $path, $matches, null, $pathOffset);
		} else {
			$result = preg_match('(^' . $this->regex . '$)', $path, $matches);
		}
	
		if (!$result) {
			return null;
		}
	
		$matchedLength = strlen($matches[0]);
	
		foreach ($matches as $key => $value) {
			if (is_numeric($key) || is_int($key) || $value === '') {
				unset($matches[$key]);
			} else {
				$matches[$key] = rawurldecode($value);
			}
		}
	
		return new RouteMatch(array_merge($this->defaults, $matches), $matchedLength);
	}
}