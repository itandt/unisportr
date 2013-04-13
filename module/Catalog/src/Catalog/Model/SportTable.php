<?php
namespace Catalog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Platform\Platform;
use ITT\Util\Utility;

class SportTable {
	
	const SPORT_TITLE_UNASSIGNED = 'unassigned';
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll() {
		$where = new Where();
		$where->notEqualTo('title', '');
		$resultSet = $this->tableGateway->select($where);
		return $resultSet;
	}
	
	public function findAllByCityName($cityName) {
		$select = new Select();
		$where = new Where();
		$select->columns(array(
			'id', 'title' => new Expression('IFNULL(sports.title, "' . Utility::poedit('Unassigned') . '")'), 'category'
		));
		$select->from($this->tableGateway->getTable());
		$select
			->join('courses_sports', 'courses_sports.sport_id = sports.id', array(), Select::JOIN_RIGHT)
			->join('courses', 'courses_sports.course_id = courses.id', array(), Select::JOIN_RIGHT)
			->join('allproviders', 'courses.provider_id = allproviders.providerid', array())
			->join('cities', 'cities.id = allproviders.city_id', array(
				'countCourses' => new Expression('COUNT(courses.id)'))
			)
		;
		$where
			->greaterThan('courses.enddate', new Expression('NOW()'))
			->equalTo('cities.name', $cityName)
		;
		$select->where($where, Predicate::OP_AND);
		$select->group(array('sports.id', 'sports.category'));
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
}