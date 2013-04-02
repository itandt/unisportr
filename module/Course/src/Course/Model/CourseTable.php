<?php
namespace Course\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Platform\Platform;

class CourseTable {
	
	const CONCAT_DELIMITER = '|||';
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function findOnceByID($id) {
		$concatDelimiter = self::CONCAT_DELIMITER;
		$select = new Select();
		$where = new Where();
		$select->columns(array(
			'id', 'courseID01' => 'courseid01', 'courseID02' => 'courseid02',
			'title', 'description',
			'url', 'bookingLink' => 'bookinglink',
			'priceStudent' => 'pricestudent', 'priceEmployee' => 'priceemployee', 'priceNormal' => 'pricenormal',
			'startDate' => new Expression('DATE_FORMAT(courses.startdate, "%e\.%m\.%Y")'),
			'endDate' => new Expression('DATE_FORMAT(courses.enddate, "%e\.%m\.%Y")'),
			'startTime' => new Expression('DATE_FORMAT(courses.starttime, "%H\:%i")'),
			'endTime' => new Expression('DATE_FORMAT(courses.endtime, "%H\:%i")'),
			'location', 'status',
		));
		$select->from($this->tableGateway->getTable());
		$select
			->join('allproviders', 'courses.provider_id = allproviders.providerid', array(
				'providerName' => 'displayedname', 'providerType' => 'providertype', 'providerURL' => 'url'
			))
			->join('cities', 'allproviders.city_id = cities.id', array(
				'city' => 'name'
			))
			->join('weekdays', 'courses.weekday_id = weekdays.id', array(
				'weekday' => 'labelde'
			))
			->join(array('levelsmin' => 'levels'), 'courses.levelmin_id = levelsmin.id', array(
				'usrLevelMin' => 'usrlevel', 'uniLevelMin' => 'unilevel'
			), Select::JOIN_LEFT)
			->join(array('levelsmax' =>'levels'), 'courses.levelmax_id = levelsmax.id', array(
				'usrLevelMax' => 'usrlevel', 'uniLevelMax' => 'unilevel'
			), Select::JOIN_LEFT)
			->join('courses_trainers', 'courses.id = courses_trainers.course_id', array())
			->join('trainers', 'trainer_id = trainers.id', array(
				'trainers' => new Expression("GROUP_CONCAT(trainers.name SEPARATOR '$concatDelimiter')")
			))
		;
		$where
			->equalTo('courses.id', $id)
		;
		$select->where($where, Predicate::OP_AND);
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
}