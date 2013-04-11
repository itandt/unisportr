<?php
namespace Cache\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Predicate;

class CityTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	/**
	 * @return ResultSet
	 */
	public function fetchAll() {
		$select = new Select();
		$where = new Where();
		$select->columns(array('id', 'name'));
		$select->from($this->tableGateway->getTable());
		$select
			->join('allproviders', 'allproviders.city_id = cities.id', array())
			->join('courses', 'courses.provider_id = allproviders.providerid', array())
		;
		$where->notEqualTo('name', '');
		$where->isNull('courses.status');
		$select->where($where, Predicate::OP_AND);
		$select->quantifier(Select::QUANTIFIER_DISTINCT);
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
}