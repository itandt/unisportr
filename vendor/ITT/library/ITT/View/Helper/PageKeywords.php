<?php
namespace ITT\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * Builds the page keywords string,
 * that can be used for the meta keywords.
 * @author automatix
 */
class PageKeywords extends AbstractHelper {

	const APPEND  = 'append';
	const PREPEND = 'prepend';
	const DELIMITER = ', ';

	/**
	 *
	 * @param array|string $keywords
	 * @param string $baseKeywords
	 * @param string $position
	 */
	public function __invoke($keywords, $baseKeywords, $position = static::APPEND) {
		$keywordsString = is_array($keywords)
			? implode(static::DELIMITER, $keywords)
			: $keywords
		;
		switch ($position) {
			case static::APPEND:
				$keywordsString = $baseKeywords . static::DELIMITER . $keywordsString;
				break;
			case static::PREPEND:
			default:
				$keywordsString = $keywordsString . static::DELIMITER . $baseKeywords;
				break;
		}
	}

}