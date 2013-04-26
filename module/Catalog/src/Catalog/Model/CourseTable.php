<?php
namespace Catalog\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Platform\Platform;

class CourseTable {
	
	const SPORT_TITLE_UNASSIGNED = 'Unassigned';
	
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
	
	public function findAllByCityNameAndSportTitle($cityName, $sportTitle, $pageNumber) {
		$select = new Select();
		$where = new Where();
		$select->columns(array(
			'id', 'title',
			'startDate' => new Expression('DATE_FORMAT(courses.startdate, "%e\.%m\.%Y")'),
			'endDate' => new Expression('DATE_FORMAT(courses.enddate, "%e\.%m\.%Y")'),
			'startTime' => new Expression('DATE_FORMAT(courses.starttime, "%H\:%i")'),
			'endTime' => new Expression('DATE_FORMAT(courses.endtime, "%H\:%i")'),
		));
		$select->from($this->tableGateway->getTable());
		$select
			->join('allproviders', 'courses.provider_id = allproviders.providerid', array(
					'providerName' => 'displayedname', 'providerType' => 'providertype'
			))
			->join('cities', 'allproviders.city_id = cities.id', array(
				'cityName' => 'name'
			))
			->join('courses_sports', 'courses_sports.course_id = courses.id', array(), Select::JOIN_LEFT)
			->join('sports', 'courses_sports.sport_id = sports.id', array(
				'sportTitle' => 'title'
			), Select::JOIN_LEFT)
			->join('weekdays', 'courses.weekday_id = weekdays.id', array(
				'weekday' => 'labelde'
			), Select::JOIN_LEFT)
			->join(array('levelsmin' => 'levels'), 'courses.levelmin_id = levelsmin.id', array(
				'usrLevelMin' => 'usrlevel', 'uniLevelMin' => 'unilevel'
			), Select::JOIN_LEFT)
			->join(array('levelsmax' =>'levels'), 'courses.levelmax_id = levelsmax.id', array(
				'usrLevelMax' => 'usrlevel', 'uniLevelMax' => 'unilevel'
			), Select::JOIN_LEFT)
		;
		$where
			->greaterThan('courses.enddate', new Expression('NOW()'))
			->equalTo('cities.name', $cityName)
		;
		// Filter by sports.title only if the passed sport title != self::SPORT_TITLE_UNASSIGNED
		if (strcasecmp($sportTitle, self::SPORT_TITLE_UNASSIGNED) !== 0) {
			$where->equalTo('sports.title', $sportTitle);
		} else {
			$where->isNull('sports.title');
		}
		$select->where($where, Predicate::OP_AND);
		$select->group(array('courses.id'));
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());

		$adapter = new \ITT\Paginator\Adapter\DbSelect($select, $this->tableGateway->getAdapter());
		$paginator = new \Zend\Paginator\Paginator($adapter);
		$paginator->setCurrentPageNumber($pageNumber);
		
		return $paginator;
	}
	
}