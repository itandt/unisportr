<?php
namespace ITT\Util;

class Utility {
	
	public static function getOneOrPair($elementA, $elementB, $delimiter) {
		$return = null;
		if($elementA == $elementB) {
			$return = $elementA;
		} else {
			if (empty($elementA)) {
				$return = $elementB;
			} else if (empty($elementB)) {
				$return = $elementA;
			} else {
				$return = $elementA . $delimiter . $elementB;
			}
		}
		return $return;
	}
	
	public static function poedit($keyString) {
		return $keyString;
	}
	
}