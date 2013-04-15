<?php
namespace Search\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Platform\Platform;
use Zend\Db\Sql\Having;

class CourseTable {
	
	const CONCAT_DELIMITER = '|||';
	const RELEVANCE_TITLE = 5;
	const RELEVANCE_DESCRIPTION = 2;
	const RELEVANCE_MIN = 3;
	
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
	
	public function findAllByCriteria(CourseSearchInput $input) {
		$concatDelimiter = self::CONCAT_DELIMITER;
		$select = new Select();
		$where = $this->buildWhereFromCriteria($input);
		$having = new Having();
		$select->columns(array(
			'id', 'title', 'description',
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
			->join('coursedata', 'courses.id = coursedata.id', array(
				'relevance' => $this->buildRelevanceExpressionFromCriteria($input)
			))
			->join('courses_trainers', 'courses.id = courses_trainers.course_id', array(), Select::JOIN_LEFT)
			->join('trainers', 'trainer_id = trainers.id', array(
				'trainers' => new Expression("GROUP_CONCAT(trainers.name SEPARATOR '$concatDelimiter')")
			), Select::JOIN_LEFT)
		;
		$where
			->greaterThan('courses.enddate', new Expression('NOW()'))
		;
		$having
			->greaterThanOrEqualTo('relevance', self::RELEVANCE_MIN);
		;
		$select->where($where, Predicate::OP_AND);
		$select->having($having);
		$select->group(array('courses.id'));
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
		
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
	public function buildRelevanceExpressionFromCriteria(CourseSearchInput $input) {
		$criteria = $input->getArrayCopy();
		$relevanceTitle = self::RELEVANCE_TITLE;
		$relevanceDescription = self::RELEVANCE_DESCRIPTION;
		$expressionSQL = <<<SQL
MATCH (coursedata.title) AGAINST ('{$criteria['keyword']}') * $relevanceTitle +
MATCH (coursedata.description) AGAINST ('{$criteria['keyword']}') * $relevanceDescription
SQL;
		return new Expression($expressionSQL);
	}
	
	function buildWhereFromCriteria(CourseSearchInput $input) {
		$where = new Where();
		$criteria = $input->getArrayCopy();
		$where->equalTo('cities.id', $criteria['city']);
		$where->in('weekdays.id', $criteria['weekday']);
		if (!empty($criteria['trainer'])) {
			$where->like('trainers.name', '%' . $criteria['trainer'] . '%');
		}
		return $where;
	}
	
}