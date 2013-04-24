<?php
namespace ITT\View\Helper;

use Zend\View\Helper\Url as ZendUrl;

class Url extends ZendUrl {
	
	public function __invoke($name = null, array $params = array(), $options = array(), $reuseMatchedParams = false) {
		$link = parent::__invoke($name, $params, $options, $reuseMatchedParams);
		// replace new line chaacters with whitespaces
		$link = str_replace('%0A', '%20', $link);
		// replace slashes with hyphens
		$link = str_replace('%2F', '-', $link);
		return $link;
	}
	
}