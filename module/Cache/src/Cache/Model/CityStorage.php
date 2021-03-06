<?php
namespace Cache\Model;

use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Catalog\Model\CityTable;
use Catalog\Model\City;

class CityStorage {
	
	const CACHE_LISTENER_CITIES = 'cache_cities';
	
	/**
	 * @var CityTable
	 */
	private $cityTable;
	/**
	 * @var AbstractAdapter
	 */
	private $cacheAdapter;
	
	public function __construct(CityTable $cityTable, AbstractAdapter $cacheAdapter) {
		$this->cityTable	= $cityTable;
		$this->cacheAdapter	= $cacheAdapter;
		// $this->cacheAdapter->removeItem(self::CACHE_LISTENER_CITIES);
	}
	
	public function getCities() {
		if (!$this->cacheAdapter->hasItem(self::CACHE_LISTENER_CITIES)) {
			$this->cacheCities();
		}
		$cities = $this->cacheAdapter->getItem(self::CACHE_LISTENER_CITIES);
		return $cities;
	}
	
	private function cacheCities() {
		$cities = $this->getCitiesShallowArray();
		$this->cacheAdapter->setItem(self::CACHE_LISTENER_CITIES, $cities);
	}
	
	private function getCitiesShallowArray() {
		$cities = array();
		foreach ($this->cityTable->fetchAll() as $city) {
			$cities[] = $city;
		}
		return $cities;
	}
	
}