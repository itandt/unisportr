<?php
namespace CatalogTest\Model;

use Catalog\Model\City;
use PHPUnit_Framework_TestCase;

class CityTest extends PHPUnit_Framework_TestCase {
	
    public function testCityInitialState() {
        $city = new City();
        $this->assertNull($city->name, '"name" should initially be null');
        $this->assertNull($city->id, '"id" should initially be null');
    }
    
    public function testExchangeArraySetsPropertiesCorrectly() {
    	$city = new City();
        $data = array(
			'name' => 'some name',
			'id'   => 123
        );
        $city->exchangeArray($data);
        $this->assertSame($data['name'], $city->name, '"name" was not set correctly');
        $this->assertSame($data['id'], $city->id, '"id" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $city = new City();
        $city->exchangeArray(array(
        	'name' => 'some name',
            'id'   => 123
        ));
        $city->exchangeArray(array());
        $this->assertNull($city->name, '"name" should have defaulted to null');
        $this->assertNull($city->id, '"id" should have defaulted to null');
    }
}