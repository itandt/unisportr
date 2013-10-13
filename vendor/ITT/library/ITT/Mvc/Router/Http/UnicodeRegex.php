<?php
namespace ITT\Mvc\Router\Http;

use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Mvc\Router\Http\Regex;

class UnicodeRegex extends Regex
{
	/**
	 * match(): defined by RouteInterface interface.
	 *
	 * @param  Request $request
	 * @param  integer $pathOffset
	 * @return RouteMatch
	 */
	public function match(Request $request, $pathOffset = null)
	{
		if (!method_exists($request, 'getUri')) {
			return null;
		}
	
		$uri  = $request->getUri();
		$path = rawurldecode($uri->getPath());
	
		if ($pathOffset !== null) {
			$result = preg_match('(\G' . $this->regex . ')u', $path, $matches, null, $pathOffset);
		} else {
			$result = preg_match('(^' . $this->regex . '$)u', $path, $matches);
		}
	
		if (!$result) {
			return null;
		}
	
		foreach ($matches as $key => $value) {
			if (is_numeric($key) || is_int($key) || $value === '') {
				unset($matches[$key]);
			} else {
				$matches[$key] = rawurldecode($value);
			}
		}
	
		// at this point there's a mismatch between the length of the rawurlencoded path
		// that all other route helpers use, so we need to match their expectations
		// to do that we build the matched part from the spec, using the matched params 
		$url = $this->spec;
		$mergedParams = array_merge($this->defaults, $matches);
		foreach ($mergedParams as $key => $value) {
			$spec = '%' . $key . '%';
			if (strpos($url, $spec) !== false) {
				$url = str_replace($spec, rawurlencode($value), $url);
			}
		}
		// make sure the url we built from spec exists in the original uri path
		if (false === strpos(rawurldecode($uri->getPath()), rawurldecode($url))) {
			return null;
		}
		// now we can get the matchedLength
		
		$matchedLength = strlen($url);
	
		return new RouteMatch($mergedParams, $matchedLength);
	}
}