<?php
namespace ITT\Paginator\Adapter;

use Zend\Paginator\Adapter\DbSelect as ZendDbSelect;
use Zend\Db\Sql\Select;

/**
 * Overwrites the count() in order to avoid breaking of GROUP BY clauses by the standard count().
 */
class DbSelect extends ZendDbSelect {
	
	public function count()
	{
		if ($this->rowCount !== null) {
			return $this->rowCount;
		}
	
		/**
		 * If the query hasn't got a join just try and use the old method
		 */
		$stateGroup = $this->select->getRawState('group');
		if( ! isset($stateGroup) || empty($stateGroup)) {
			return parent::count();
		}
	
		$select = clone $this->select;
		$select->reset(Select::LIMIT);
		$select->reset(Select::OFFSET);
	
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$result    = $statement->execute();
	
		$this->rowCount = $result->count();
	
		return $this->rowCount;
	}
	
}
