<?php
namespace ITT\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * Builds the page description text,
 * that can be used for the title tag and/or the meta description.
 * @author automatix
 */
class PageDescription extends AbstractHelper {
	
	const APPEND  = 'append';
	const PREPEND = 'prepend';
	const DELIMITER = ' - ';
	
	/**
	 * 
	 * @param unknown $titleText
	 * @param unknown $baseTitle
	 * @param unknown $position
	 * @param unknown $dilimiter
	 */
	public function __invoke($titleText, $baseTitle, $position = static::APPEND, $dilimiter = static::DELIMITER) {
		
	}
	
}