<?php
namespace Cache\Model;

use Zend\Cache\Storage\Adapter\AbstractAdapter;
use Catalog\Model\UniversityTable;
use Catalog\Model\University;

class UniversityStorage {
	
	const CACHE_LISTENER_UNIVERSITIES = 'cache_universities';
	
	/**
	 * @var UniversityTable
	 */
	private $universityTable;
	/**
	 * @var AbstractAdapter
	 */
	private $cacheAdapter;
	
	public function __construct(UniversityTable $universityTable, AbstractAdapter $cacheAdapter) {
		$this->universityTable	= $universityTable;
		$this->cacheAdapter	= $cacheAdapter;
		// $this->cacheAdapter->removeItem(self::CACHE_LISTENER_UNIVERSITIES);
	}
	
	public function getUniversities() {
		if (!$this->cacheAdapter->hasItem(self::CACHE_LISTENER_UNIVERSITIES)) {
			$this->cacheUniversities();
		}
		$universities = $this->cacheAdapter->getItem(self::CACHE_LISTENER_UNIVERSITIES);
		return $universities;
	}
	
	private function cacheUniversities() {
		$universities = $this->getUniversitiesShallowArray();
		$this->cacheAdapter->setItem(self::CACHE_LISTENER_UNIVERSITIES, $universities);
	}
	
	private function getUniversitiesShallowArray() {
		$universities = array();
		foreach ($this->universityTable->fetchAllSupported() as $university) {
			$universities[] = $university;
		}
		return $universities;
	}
	
}