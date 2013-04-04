<?php
namespace Cache\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;

class CityTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	/**
	 * @return ResultSet
	 */
	public function fetchAll() {
		$where = new Where();
		$where->notEqualTo('name', '');
		$resultSet = $this->tableGateway->select($where);
		return $resultSet;
	}
	
}