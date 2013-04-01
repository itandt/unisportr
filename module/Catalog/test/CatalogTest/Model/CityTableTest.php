<?php
namespace CatalogTest\Model;

use Catalog\Model\CityTable;
use Catalog\Model\City;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class CityTableTest extends PHPUnit_Framework_TestCase {
		
	public function testFetchAllReturnsAllCities() {
		$resultSet = new ResultSet();
		$mockTableGateway = $this->getMock(
			'Zend\Db\TableGateway\TableGateway', array('select'), array(), '',  false
		);
		$mockTableGateway
			->expects($this->once())
			->method('select')
			->with()
			->will($this->returnValue($resultSet))
		;
		$cityTable = new CityTable($mockTableGateway);
		$this->assertSame($resultSet, $cityTable->fetchAll());
	}
	
}