<?php

namespace Base;

use \RequestFood as ChildRequestFood;
use \RequestFoodQuery as ChildRequestFoodQuery;
use \Exception;
use \PDO;
use Map\RequestFoodTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'request_food' table.
 *
 *
 *
 * @method     ChildRequestFoodQuery orderByRequestId($order = Criteria::ASC) Order by the request_id column
 * @method     ChildRequestFoodQuery orderByFoodId($order = Criteria::ASC) Order by the food_id column
 *
 * @method     ChildRequestFoodQuery groupByRequestId() Group by the request_id column
 * @method     ChildRequestFoodQuery groupByFoodId() Group by the food_id column
 *
 * @method     ChildRequestFoodQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRequestFoodQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRequestFoodQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRequestFoodQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRequestFoodQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRequestFoodQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRequestFoodQuery leftJoinRequest($relationAlias = null) Adds a LEFT JOIN clause to the query using the Request relation
 * @method     ChildRequestFoodQuery rightJoinRequest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Request relation
 * @method     ChildRequestFoodQuery innerJoinRequest($relationAlias = null) Adds a INNER JOIN clause to the query using the Request relation
 *
 * @method     ChildRequestFoodQuery joinWithRequest($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Request relation
 *
 * @method     ChildRequestFoodQuery leftJoinWithRequest() Adds a LEFT JOIN clause and with to the query using the Request relation
 * @method     ChildRequestFoodQuery rightJoinWithRequest() Adds a RIGHT JOIN clause and with to the query using the Request relation
 * @method     ChildRequestFoodQuery innerJoinWithRequest() Adds a INNER JOIN clause and with to the query using the Request relation
 *
 * @method     ChildRequestFoodQuery leftJoinFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the Food relation
 * @method     ChildRequestFoodQuery rightJoinFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Food relation
 * @method     ChildRequestFoodQuery innerJoinFood($relationAlias = null) Adds a INNER JOIN clause to the query using the Food relation
 *
 * @method     ChildRequestFoodQuery joinWithFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Food relation
 *
 * @method     ChildRequestFoodQuery leftJoinWithFood() Adds a LEFT JOIN clause and with to the query using the Food relation
 * @method     ChildRequestFoodQuery rightJoinWithFood() Adds a RIGHT JOIN clause and with to the query using the Food relation
 * @method     ChildRequestFoodQuery innerJoinWithFood() Adds a INNER JOIN clause and with to the query using the Food relation
 *
 * @method     \RequestQuery|\FoodQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRequestFood findOne(ConnectionInterface $con = null) Return the first ChildRequestFood matching the query
 * @method     ChildRequestFood findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRequestFood matching the query, or a new ChildRequestFood object populated from the query conditions when no match is found
 *
 * @method     ChildRequestFood findOneByRequestId(int $request_id) Return the first ChildRequestFood filtered by the request_id column
 * @method     ChildRequestFood findOneByFoodId(int $food_id) Return the first ChildRequestFood filtered by the food_id column *

 * @method     ChildRequestFood requirePk($key, ConnectionInterface $con = null) Return the ChildRequestFood by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestFood requireOne(ConnectionInterface $con = null) Return the first ChildRequestFood matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequestFood requireOneByRequestId(int $request_id) Return the first ChildRequestFood filtered by the request_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestFood requireOneByFoodId(int $food_id) Return the first ChildRequestFood filtered by the food_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequestFood[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRequestFood objects based on current ModelCriteria
 * @method     ChildRequestFood[]|ObjectCollection findByRequestId(int $request_id) Return ChildRequestFood objects filtered by the request_id column
 * @method     ChildRequestFood[]|ObjectCollection findByFoodId(int $food_id) Return ChildRequestFood objects filtered by the food_id column
 * @method     ChildRequestFood[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RequestFoodQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RequestFoodQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\RequestFood', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRequestFoodQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRequestFoodQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRequestFoodQuery) {
            return $criteria;
        }
        $query = new ChildRequestFoodQuery();
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
     * @param array[$request_id, $food_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRequestFood|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RequestFoodTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RequestFoodTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRequestFood A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT request_id, food_id FROM request_food WHERE request_id = :p0 AND food_id = :p1';
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
            /** @var ChildRequestFood $obj */
            $obj = new ChildRequestFood();
            $obj->hydrate($row);
            RequestFoodTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRequestFood|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RequestFoodTableMap::COL_REQUEST_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RequestFoodTableMap::COL_FOOD_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the request_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRequestId(1234); // WHERE request_id = 1234
     * $query->filterByRequestId(array(12, 34)); // WHERE request_id IN (12, 34)
     * $query->filterByRequestId(array('min' => 12)); // WHERE request_id > 12
     * </code>
     *
     * @see       filterByRequest()
     *
     * @param     mixed $requestId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByRequestId($requestId = null, $comparison = null)
    {
        if (is_array($requestId)) {
            $useMinMax = false;
            if (isset($requestId['min'])) {
                $this->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $requestId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requestId['max'])) {
                $this->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $requestId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $requestId, $comparison);
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
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByFoodId($foodId = null, $comparison = null)
    {
        if (is_array($foodId)) {
            $useMinMax = false;
            if (isset($foodId['min'])) {
                $this->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $foodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($foodId['max'])) {
                $this->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $foodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $foodId, $comparison);
    }

    /**
     * Filter the query by a related \Request object
     *
     * @param \Request|ObjectCollection $request The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByRequest($request, $comparison = null)
    {
        if ($request instanceof \Request) {
            return $this
                ->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $request->getId(), $comparison);
        } elseif ($request instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RequestFoodTableMap::COL_REQUEST_ID, $request->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRequest() only accepts arguments of type \Request or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Request relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function joinRequest($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Request');

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
            $this->addJoinObject($join, 'Request');
        }

        return $this;
    }

    /**
     * Use the Request relation Request object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RequestQuery A secondary query class using the current class as primary query
     */
    public function useRequestQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRequest($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Request', '\RequestQuery');
    }

    /**
     * Filter the query by a related \Food object
     *
     * @param \Food|ObjectCollection $food The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRequestFoodQuery The current query, for fluid interface
     */
    public function filterByFood($food, $comparison = null)
    {
        if ($food instanceof \Food) {
            return $this
                ->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $food->getId(), $comparison);
        } elseif ($food instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RequestFoodTableMap::COL_FOOD_ID, $food->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
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
     * @param   ChildRequestFood $requestFood Object to remove from the list of results
     *
     * @return $this|ChildRequestFoodQuery The current query, for fluid interface
     */
    public function prune($requestFood = null)
    {
        if ($requestFood) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RequestFoodTableMap::COL_REQUEST_ID), $requestFood->getRequestId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RequestFoodTableMap::COL_FOOD_ID), $requestFood->getFoodId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the request_food table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RequestFoodTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RequestFoodTableMap::clearInstancePool();
            RequestFoodTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RequestFoodTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RequestFoodTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RequestFoodTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RequestFoodTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RequestFoodQuery
