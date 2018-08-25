<?php

namespace Base;

use \ComboFood as ChildComboFood;
use \ComboFoodQuery as ChildComboFoodQuery;
use \Exception;
use \PDO;
use Map\ComboFoodTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'combo_food' table.
 *
 *
 *
 * @method     ChildComboFoodQuery orderByComboId($order = Criteria::ASC) Order by the combo_id column
 * @method     ChildComboFoodQuery orderByFoodId($order = Criteria::ASC) Order by the food_id column
 *
 * @method     ChildComboFoodQuery groupByComboId() Group by the combo_id column
 * @method     ChildComboFoodQuery groupByFoodId() Group by the food_id column
 *
 * @method     ChildComboFoodQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildComboFoodQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildComboFoodQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComboFoodQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildComboFoodQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildComboFoodQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildComboFoodQuery leftJoinCombo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Combo relation
 * @method     ChildComboFoodQuery rightJoinCombo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Combo relation
 * @method     ChildComboFoodQuery innerJoinCombo($relationAlias = null) Adds a INNER JOIN clause to the query using the Combo relation
 *
 * @method     ChildComboFoodQuery joinWithCombo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Combo relation
 *
 * @method     ChildComboFoodQuery leftJoinWithCombo() Adds a LEFT JOIN clause and with to the query using the Combo relation
 * @method     ChildComboFoodQuery rightJoinWithCombo() Adds a RIGHT JOIN clause and with to the query using the Combo relation
 * @method     ChildComboFoodQuery innerJoinWithCombo() Adds a INNER JOIN clause and with to the query using the Combo relation
 *
 * @method     ChildComboFoodQuery leftJoinFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the Food relation
 * @method     ChildComboFoodQuery rightJoinFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Food relation
 * @method     ChildComboFoodQuery innerJoinFood($relationAlias = null) Adds a INNER JOIN clause to the query using the Food relation
 *
 * @method     ChildComboFoodQuery joinWithFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Food relation
 *
 * @method     ChildComboFoodQuery leftJoinWithFood() Adds a LEFT JOIN clause and with to the query using the Food relation
 * @method     ChildComboFoodQuery rightJoinWithFood() Adds a RIGHT JOIN clause and with to the query using the Food relation
 * @method     ChildComboFoodQuery innerJoinWithFood() Adds a INNER JOIN clause and with to the query using the Food relation
 *
 * @method     \ComboQuery|\FoodQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComboFood findOne(ConnectionInterface $con = null) Return the first ChildComboFood matching the query
 * @method     ChildComboFood findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComboFood matching the query, or a new ChildComboFood object populated from the query conditions when no match is found
 *
 * @method     ChildComboFood findOneByComboId(int $combo_id) Return the first ChildComboFood filtered by the combo_id column
 * @method     ChildComboFood findOneByFoodId(int $food_id) Return the first ChildComboFood filtered by the food_id column *

 * @method     ChildComboFood requirePk($key, ConnectionInterface $con = null) Return the ChildComboFood by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComboFood requireOne(ConnectionInterface $con = null) Return the first ChildComboFood matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComboFood requireOneByComboId(int $combo_id) Return the first ChildComboFood filtered by the combo_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComboFood requireOneByFoodId(int $food_id) Return the first ChildComboFood filtered by the food_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComboFood[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComboFood objects based on current ModelCriteria
 * @method     ChildComboFood[]|ObjectCollection findByComboId(int $combo_id) Return ChildComboFood objects filtered by the combo_id column
 * @method     ChildComboFood[]|ObjectCollection findByFoodId(int $food_id) Return ChildComboFood objects filtered by the food_id column
 * @method     ChildComboFood[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ComboFoodQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ComboFoodQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ComboFood', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildComboFoodQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildComboFoodQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildComboFoodQuery) {
            return $criteria;
        }
        $query = new ChildComboFoodQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$combo_id, $food_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildComboFood|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComboFoodTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ComboFoodTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComboFood A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT combo_id, food_id FROM combo_food WHERE combo_id = :p0 AND food_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildComboFood $obj */
            $obj = new ChildComboFood();
            $obj->hydrate($row);
            ComboFoodTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildComboFood|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ComboFoodTableMap::COL_COMBO_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ComboFoodTableMap::COL_FOOD_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the combo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByComboId(1234); // WHERE combo_id = 1234
     * $query->filterByComboId(array(12, 34)); // WHERE combo_id IN (12, 34)
     * $query->filterByComboId(array('min' => 12)); // WHERE combo_id > 12
     * </code>
     *
     * @see       filterByCombo()
     *
     * @param     mixed $comboId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByComboId($comboId = null, $comparison = null)
    {
        if (is_array($comboId)) {
            $useMinMax = false;
            if (isset($comboId['min'])) {
                $this->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $comboId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comboId['max'])) {
                $this->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $comboId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $comboId, $comparison);
    }

    /**
     * Filter the query on the food_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFoodId(1234); // WHERE food_id = 1234
     * $query->filterByFoodId(array(12, 34)); // WHERE food_id IN (12, 34)
     * $query->filterByFoodId(array('min' => 12)); // WHERE food_id > 12
     * </code>
     *
     * @see       filterByFood()
     *
     * @param     mixed $foodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByFoodId($foodId = null, $comparison = null)
    {
        if (is_array($foodId)) {
            $useMinMax = false;
            if (isset($foodId['min'])) {
                $this->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $foodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($foodId['max'])) {
                $this->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $foodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $foodId, $comparison);
    }

    /**
     * Filter the query by a related \Combo object
     *
     * @param \Combo|ObjectCollection $combo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByCombo($combo, $comparison = null)
    {
        if ($combo instanceof \Combo) {
            return $this
                ->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $combo->getId(), $comparison);
        } elseif ($combo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComboFoodTableMap::COL_COMBO_ID, $combo->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCombo() only accepts arguments of type \Combo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Combo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function joinCombo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Combo');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Combo');
        }

        return $this;
    }

    /**
     * Use the Combo relation Combo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ComboQuery A secondary query class using the current class as primary query
     */
    public function useComboQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCombo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Combo', '\ComboQuery');
    }

    /**
     * Filter the query by a related \Food object
     *
     * @param \Food|ObjectCollection $food The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComboFoodQuery The current query, for fluid interface
     */
    public function filterByFood($food, $comparison = null)
    {
        if ($food instanceof \Food) {
            return $this
                ->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $food->getId(), $comparison);
        } elseif ($food instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComboFoodTableMap::COL_FOOD_ID, $food->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFood() only accepts arguments of type \Food or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Food relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function joinFood($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Food');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Food');
        }

        return $this;
    }

    /**
     * Use the Food relation Food object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FoodQuery A secondary query class using the current class as primary query
     */
    public function useFoodQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFood($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Food', '\FoodQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildComboFood $comboFood Object to remove from the list of results
     *
     * @return $this|ChildComboFoodQuery The current query, for fluid interface
     */
    public function prune($comboFood = null)
    {
        if ($comboFood) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ComboFoodTableMap::COL_COMBO_ID), $comboFood->getComboId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ComboFoodTableMap::COL_FOOD_ID), $comboFood->getFoodId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the combo_food table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComboFoodTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ComboFoodTableMap::clearInstancePool();
            ComboFoodTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComboFoodTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ComboFoodTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ComboFoodTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ComboFoodTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ComboFoodQuery
