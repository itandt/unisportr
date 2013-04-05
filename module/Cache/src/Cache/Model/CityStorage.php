<?php
namespace Cache\Model;

use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Cache\Model\CityTable;

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
	}
	
	public function getCities() {
		if (!$this->cacheAdapter->hasItem(self::CACHE_LISTENER_CITIES)) {
			$this->cacheCities();
		}
		$cities = $this->cacheAdapter->getItem(self::CACHE_LISTENER_CITIES);
		return $cities;
	}
	
	private function cacheCities() {
		$cities = $this->cityTable->fetchAll()->toArray();
		$this->cacheAdapter->setItem(self::CACHE_LISTENER_CITIES, $cities);
	}
	
}