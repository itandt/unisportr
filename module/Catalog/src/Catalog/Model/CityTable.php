<?php
namespace Catalog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;

class CityTable {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll() {
		$where = new Where();
		$where->notEqualTo('name', '');
		$resultSet = $this->tableGateway->select($where);
		return $resultSet;
	}
	
}