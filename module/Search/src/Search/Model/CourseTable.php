<?php
namespace Search\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Platform\Platform;
use Zend\Db\Sql\Having;
use Zend\Db\Sql\Predicate\Operator;

class CourseTable {
	
	const CONCAT_DELIMITER = '|||';
	
	protected $tableGateway;
	protected $relevanceMin;
	protected $relevanceMinTitle;
	protected $relevanceMinDescription;
	protected $relevanceMinWeightageTitle;
	protected $relevanceMinWeightageDescription;
	
	public function __construct(
		TableGateway $tableGateway,
		$relevanceMin,
		$relevanceMinTitle, $relevanceMinDescription,
		$relevanceMinWeightageTitle, $relevanceMinWeightageDescription
	) {
		$this->tableGateway = $tableGateway;
		$this->relevanceMin = $relevanceMin;
		$this->relevanceMinTitle = $relevanceMinTitle;
		$this->relevanceMinDescription = $relevanceMinDescription;
		$this->relevanceMinWeightageTitle = $relevanceMinWeightageTitle;
		$this->relevanceMinWeightageDescription = $relevanceMinWeightageDescription;
	}
	
	public function fetchAll() {
		$where = new Where();
		$where->notEqualTo('title', '');
		$resultSet = $this->tableGateway->select($where);
		return $resultSet;
	}
	
	public function findAllByCriteria(CourseSearchInput $input, $pageNumber) {
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
			->join('coursedata', 'courses.coursedata_id = coursedata.id', array(
				'relevanceAggregated' => $this->buildrelevanceAggregatedExpressionFromCriteria($input),
				'relevanceTitle' => $this->buildRelevanceTitleExpressionFromCriteria($input),
				'relevanceDescription' => $this->buildRelevanceDescriptionExpressionFromCriteria($input)
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
			->greaterThanOrEqualTo('relevanceAggregated', $this->calculateRelevanceMinAggregated());
		;
		$select->where($where, Predicate::OP_AND);
		$select->having($having);
		$select->group(array('courses.id'));
		$select->order('relevanceAggregated DESC, title');
		// $test = $select->getSqlString($this->tableGateway->getAdapter()->getPlatform());
		
		$adapter = new \ITT\Paginator\Adapter\DbSelect($select, $this->tableGateway->getAdapter());
		$paginator = new \Zend\Paginator\Paginator($adapter);
		$paginator->setCurrentPageNumber($pageNumber);
		
		return $paginator;
	}
	
	public function buildrelevanceAggregatedExpressionFromCriteria(CourseSearchInput $input) {
		$criteria = $input->getArrayCopy();
		$relevanceTitle = $this->relevanceMinWeightageTitle;
		$relevanceDescription = $this->relevanceMinWeightageDescription;
		$expressionSQL = <<<SQL
(
	MATCH (coursedata.title) AGAINST ('{$criteria['keyword']}') * {$this->relevanceMinWeightageTitle} +
	MATCH (coursedata.description) AGAINST ('{$criteria['keyword']}') * {$this->relevanceMinWeightageDescription}
) / ({$this->relevanceMinWeightageTitle} + {$this->relevanceMinWeightageDescription})
SQL;
		return new Expression($expressionSQL);
	}
	
	public function buildRelevanceTitleExpressionFromCriteria(CourseSearchInput $input) {
		$criteria = $input->getArrayCopy();
		$expressionSQL = <<<SQL
MATCH (coursedata.title) AGAINST ('{$criteria['keyword']}')
SQL;
		return new Expression($expressionSQL);
	}
	
	public function buildRelevanceDescriptionExpressionFromCriteria(CourseSearchInput $input) {
		$criteria = $input->getArrayCopy();
		$expressionSQL = <<<SQL
MATCH (coursedata.description) AGAINST ('{$criteria['keyword']}')
SQL;
		return new Expression($expressionSQL);
	}
	
	/**
	 * Calculates the aggregated min relevance from
	 * 	the relevances of single parts (title and description)
	 * 	and their weightages
	 * .
	 * @return float
	 */
	protected function calculateRelevanceMinAggregated() {
		$minrelevanceAggregated =
			($this->relevanceMinTitle * $this->relevanceMinWeightageTitle + $this->relevanceMinDescription * $this->relevanceMinWeightageDescription) /
			($this->relevanceMinWeightageTitle + $this->relevanceMinWeightageDescription)
		;
		return $minrelevanceAggregated;
	}
	
	function buildWhereFromCriteria(CourseSearchInput $input) {
		$where = new Where();
		$criteria = $input->getArrayCopy();
		$where->equalTo('cities.id', $criteria['city']);
		$where->in('weekdays.id', $criteria['weekday']);
		if (!empty($criteria['trainer'])) {
			$where->like('trainers.name', '%' . $criteria['trainer'] . '%');
		}
		// Deactivated so far, since a lot of courses have no levels (NULL).
		/*
		if (!empty($criteria['level'])) {
			$levelWhere = new Where(array(
				new Operator('levelsmin.usrlevel', Operator::OPERATOR_LESS_THAN_OR_EQUAL_TO, $criteria['level']),
				new Operator('levelsmax.usrlevel', Operator::OPERATOR_GREATER_THAN_OR_EQUAL_TO, $criteria['level'])
			), Where::COMBINED_BY_AND);
			$where->addPredicate(
				$levelWhere
			);
		}
		*/
		return $where;
	}
	
}