<?php
namespace Search\Model;

use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Search\Model\CityTable;

class CityStorage {

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
		if (!$this->cacheAdapter->hasItem('cities')) {
			$this->cacheCities();
		}
		$cities = $this->cacheAdapter->getItem('cities');
		return $cities;
	}
	
	private function cacheCities() {
		$cities = $this->cityTable->fetchAll()->toArray();
		$this->cacheAdapter->setItem('cities', $cities);
// 		$this->cacheAdapter->setItem('cities', 123);
	}
	
}