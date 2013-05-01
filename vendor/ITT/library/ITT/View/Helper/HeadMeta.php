<?php
namespace ITT\View\Helper;

use stdClass;
use Zend\View;
use Zend\View\Exception;
use Zend\View\Helper\HeadMeta as ZendHeadMeta;
use Zend\View\Helper\Placeholder\Container\AbstractContainer;

class HeadMeta extends ZendHeadMeta
{
	const DELIMITER = ' - ';

	/**
	 * @see \Zend\View\Helper\HeadMeta::__invoke()
	 */
	public function __invoke($content = null, $keyValue = null, $keyType = 'name', $modifiers = array(), $placement = AbstractContainer::APPEND)
	{
		parent::__invoke($content, $keyValue, $keyType, $modifiers, $placement);
		return $this;
	}

	/**
	 * @see \Zend\View\Helper\HeadMeta::append()
	 */
	public function append($value) {
		if ($value->name == 'description') {
			$this->updateDescription($value, AbstractContainer::APPEND);
		} else if ($value->name == 'keywords') {
			$this->updateKeywords($value, AbstractContainer::APPEND);
		} else {
			parent::append($value);
		}
	}

	/**
	 * @see \Zend\View\Helper\HeadMeta::prepend()
	 */
	public function prepend($value) {
		if ($value->name == 'description') {
			$this->updateDescription($value, AbstractContainer::PREPEND);
		} else if ($value->name == 'keywords') {
			$this->updateKeywords($value, AbstractContainer::PREPEND);
		} else {
			parent::prepend($value);
		}
	}
	
	// Not working correctly!
	// Can cause a
	// Fatal error: Maximum function nesting level of '100' reached, aborting!
	/**
	 * @see \Zend\View\Helper\HeadMeta::set()
	 */
	public function set($value) {
		if ($value->name == 'description') {
			$this->updateDescription($value, AbstractContainer::SET);
		} else if ($value->name == 'keywords') {
			$this->updateKeywords($value, AbstractContainer::SET);
		} else {
			parent::set($value);
		}
	}
	
	/**
	 * If a description meta already exsists, extends it with $value->content,
	 * else creates a new desctiprion meta.
	 * @param \stdClass $value
	 * @param string $position
	 */
	public function updateDescription(stdClass $value, $position = AbstractContainer::SET) {
		$descriptionExists = false;
		foreach ($this->getContainer() as $item) {
	 		if ($this->isDescription($item)) {
	 			switch ($position) {
	 				case AbstractContainer::APPEND:
	 					$descriptionString = implode(static::DELIMITER, array($item->content, $value->content));
	 					break;
	 				case AbstractContainer::PREPEND:
	 					$descriptionString = implode(static::DELIMITER, array($value->content, $item->content));
	 					break;
	 				case AbstractContainer::SET:
	 				default:
	 					$descriptionString = $value->content;
	 					break;
	 			}
				$item->content = $descriptionString;
				$descriptionExists = true;
	 		}
	 	}
	 	if (!$descriptionExists) {
	 		switch ($position) {
	 			case AbstractContainer::APPEND:
	 				parent::append($value);
	 				break;
	 			case AbstractContainer::PREPEND:
	 				parent::prepend($value);
	 				break;
	 			case AbstractContainer::SET:
	 			default:
	 				parent::set($value);
	 				break;
	 		}
	 	}
	}
	
	/**
	 * If a keywords meta already exsists, extends it with $value->content,
	 * else creates a new keywords meta.
	 * @param \stdClass $value
	 * @param string $position
	 */
	public function updateKeywords(stdClass $value, $position = AbstractContainer::SET) {
		$keywordsExists = false;
		foreach ($this->getContainer() as $item) {
	 		if ($this->isKeywords($item)) {
				switch ($position) {
						case AbstractContainer::APPEND:
							$keywordsString = implode(', ', array($item->content, $value->content));
							break;
						case AbstractContainer::PREPEND:
							$keywordsString = implode(', ', array($value->content, $item->content));
							break;
						case AbstractContainer::SET:
						default:
							$keywordsString = $value->content;
							break;
				}
				$item->content = $keywordsString;
				$keywordsExists = true;
			}
		}
	 	if (!$keywordsExists) {
	 		parent::append($value);
	 	}
	}
	
// 	public function groupDescription() {
// 		$descriptionContentSet = array();
// 		foreach ($this->getContainer() as $index => $item) {
// 	 		if ($this->isDescription($item)) {
// 	 			$descriptionContentSet[] = $item->content;
// 	 		}
// 	 	}
// 	 	// $this->getContainer()->offsetUnset(0);
// 	 	if (!empty($descriptionContentSet)) {
// 	 		$groupedDescription = new stdClass();
// 	 		$groupedDescription->type = 'name';
// 	 		$groupedDescription->name = 'description';
// 	 		$groupedDescription->content = implode(', ', $descriptionContentSet);
// 	 		$groupedDescription->modifiers = array();
// 	 		$this->getContainer()->append($groupedDescription);
// 	 	}
// 	}
	
// 	public function groupKeywords() {
// 		$keywordsContentSet = array();
// 		foreach ($this->getContainer() as $index => $item) {
// 	 		if ($this->isKeywords($item)) {
// 	 			$keywordsContentSet[] = $item->content;
// 	 		}
// 	 	}
// 	 	if (!empty($keywordsContentSet)) {
// 	 		$groupedKeywords = new stdClass();
// 	 		$groupedKeywords->type = 'name';
// 	 		$groupedKeywords->name = 'keywords';
// 	 		$groupedKeywords->content = implode(', ', $keywordsContentSet);
// 	 		$groupedKeywords->modifiers = array();
// 	 		$this->getContainer()->append($groupedKeywords);
// 	 	}
// 	}
	
//	 public function updateDescription($description, $position = AbstractContainer::SET, $baseKeywords) {
//	 	;
//	 }
	
//	 public function updateKeywords($keywords, $position = AbstractContainer::SET, $baseKeywords) {
// 		foreach ($this->getContainer() as $item) {
//	 		if ($this->isKeywords($item)) {
//	 			$item->content = '~~~~***##~~';
//	 		}
//	 	}
// 		$keywordsString = is_array($keywords)
// 			? implode(static::DELIMITER, $keywords)
// 			: $keywords
// 		;
// 		switch ($position) {
// 			case AbstractContainer::APPEND:
// 				$keywordsString = $baseKeywords . static::DELIMITER . $keywordsString;
// 				break;
// 			case AbstractContainer::PREPEND:
// 				$keywordsString = $keywordsString . static::DELIMITER . $baseKeywords;
// 				break;
// 			case AbstractContainer::SET:
// 			default:
// 				// $keywordsString = $keywordsString;
// 				break;
// 		}
//	 }
	
	/**
	 * @return description meta text
	 */
	public function getDescription() {
		$description = null;
		foreach ($this->getContainer() as $item) {
			if ($this->isKeywords($item)) {
				$description = $item->content;
				break;
			}
		}
		return $description;
	}

	/**
	 * @return keywords meta text
	 */
	public function getKeywords() {
		$keywords = null;
		foreach ($this->getContainer() as $item) {
			if ($this->isKeywords($item)) {
				$keywords = $item->content;
				break;
			}
		}
		return $keywords;
	}
	
	/**
	 * Checks, whether the input $item is an approproate object for $this->container
	 * and wheter it's a description object (its name is "description")
	 * @param stdClass $item
	 * @throws Exception\InvalidArgumentException
	 * @return boolean
	 */
	public function isDescription(stdClass $item) {
		if (!in_array($item->type, $this->typeKeys)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'Invalid type "%s" provided for meta',
				$item->type
			));
		}
		return $item->name == 'description';
	}
	
	/**
	 * Checks, whether the input $item is an approproate object for $this->container
	 * and wheter it's a keywords object (its name is "keywords")
	 * @param stdClass $item
	 * @throws Exception\InvalidArgumentException
	 * @return boolean
	 */
	public function isKeywords(stdClass $item) {
		if (!in_array($item->type, $this->typeKeys)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'Invalid type "%s" provided for meta',
				$item->type
			));
		}
		return $item->name == 'keywords';
	}
	
}
