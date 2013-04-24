<?php
namespace Catalog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Expression;

class UniversityTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAllSupported() {
		$select = new Select();
		$where = new Where();
		$select->columns(array(
			'id', 'displayedName' => 'displayedname', 'formalName' => 'formalname', 'type',
			'dateTimeCreated' => 'datetimecreated', 'dateTimeLastUpdate' => 'datetimelastupdate',
			'status', 'numUpdates' => 'numupdates', 'numCourses' => 'numcourses',
			'url', 'urlSport' => 'urlsport',
			'cityID' => 'city_id', 'sport', 'numStudents' => 'numstudents',
			'scrape'
		));
		$select->from($this->tableGateway->getTable());
		$select
			->join('cities', 'cities.id = universities.city_id', array('cityName' => 'name'), Select::JOIN_LEFT)
			->join('allproviders', new Expression(
				'allproviders.providertype = \'university\'' . ' AND ' . 'allproviders.providerid = universities.id'
			), array())
			->join('courses', 'courses.provider_id = allproviders.providerid', array())
		;
		$where->equalTo('scrape', 1);
		$select->where($where);
		$select->quantifier(Select::QUANTIFIER_DISTINCT);
		$select->order('displayedname');
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
}