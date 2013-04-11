<?php
namespace ITT\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class MakeAddressGMapsFriendlier extends AbstractHelper {
	
	/**
	 * Makes the address string $address
	 * more compatible for a Google Maps Request:
	 * 	'/' is removed
	 * 	if the address doesn't contain a city, it is extended with course city
	 * @param string $address course address
	 * @param string $city course city
	 * @return string
	 */
	protected function __invoke($address, $city) {
		$address = str_replace('/', ' ', $address);
		$address = strpos($address, $city) == false
		? $address . ' ' . $city
		: $address
		;
		return $address;
	}
	
}