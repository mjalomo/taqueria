<?php

namespace Base;

use \Request as ChildRequest;
use \RequestQuery as ChildRequestQuery;
use \Exception;
use \PDO;
use Map\RequestTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'request' table.
 *
 *
 *
 * @method     ChildRequestQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRequestQuery orderByPersonName($order = Criteria::ASC) Order by the person_name column
 * @method     ChildRequestQuery orderBySpecialId($order = Criteria::ASC) Order by the special_id column
 *
 * @method     ChildRequestQuery groupById() Group by the id column
 * @method     ChildRequestQuery groupByPersonName() Group by the person_name column
 * @method     ChildRequestQuery groupBySpecialId() Group by the special_id column
 *
 * @method     ChildRequestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRequestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRequestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRequestQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRequestQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRequestQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRequestQuery leftJoinComboRequest($relationAlias = null) Adds a LEFT JOIN clause to the query using the ComboRequest relation
 * @method     ChildRequestQuery rightJoinComboRequest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ComboRequest relation
 * @method     ChildRequestQuery innerJoinComboRequest($relationAlias = null) Adds a INNER JOIN clause to the query using the ComboRequest relation
 *
 * @method     ChildRequestQuery joinWithComboRequest($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ComboRequest relation
 *
 * @method     ChildRequestQuery leftJoinWithComboRequest() Adds a LEFT JOIN clause and with to the query using the ComboRequest relation
 * @method     ChildRequestQuery rightJoinWithComboRequest() Adds a RIGHT JOIN clause and with to the query using the ComboRequest relation
 * @method     ChildRequestQuery innerJoinWithComboRequest() Adds a INNER JOIN clause and with to the query using the ComboRequest relation
 *
 * @method     ChildRequestQuery leftJoinRequestFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the RequestFood relation
 * @method     ChildRequestQuery rightJoinRequestFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RequestFood relation
 * @method     ChildRequestQuery innerJoinRequestFood($relationAlias = null) Adds a INNER JOIN clause to the query using the RequestFood relation
 *
 * @method     ChildRequestQuery joinWithRequestFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RequestFood relation
 *
 * @method     ChildRequestQuery leftJoinWithRequestFood() Adds a LEFT JOIN clause and with to the query using the RequestFood relation
 * @method     ChildRequestQuery rightJoinWithRequestFood() Adds a RIGHT JOIN clause and with to the query using the RequestFood relation
 * @method     ChildRequestQuery innerJoinWithRequestFood() Adds a INNER JOIN clause and with to the query using the RequestFood relation
 *
 * @method     \ComboRequestQuery|\RequestFoodQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRequest findOne(ConnectionInterface $con = null) Return the first ChildRequest matching the query
 * @method     ChildRequest findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRequest matching the query, or a new ChildRequest object populated from the query conditions when no match is found
 *
 * @method     ChildRequest findOneById(int $id) Return the first ChildRequest filtered by the id column
 * @method     ChildRequest findOneByPersonName(string $person_name) Return the first ChildRequest filtered by the person_name column
 * @method     ChildRequest findOneBySpecialId(string $special_id) Return the first ChildRequest filtered by the special_id column *

 * @method     ChildRequest requirePk($key, ConnectionInterface $con = null) Return the ChildRequest by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequest requireOne(ConnectionInterface $con = null) Return the first ChildRequest matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequest requireOneById(int $id) Return the first ChildRequest filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequest requireOneByPersonName(string $person_name) Return the first ChildRequest filtered by the person_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequest requireOneBySpecialId(string $special_id) Return the first ChildRequest filtered by the special_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequest[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRequest objects based on current ModelCriteria
 * @method     ChildRequest[]|ObjectCollection findById(int $id) Return ChildRequest objects filtered by the id column
 * @method     ChildRequest[]|ObjectCollection findByPersonName(string $person_name) Return ChildRequest objects filtered by the person_name column
 * @method     ChildRequest[]|ObjectCollection findBySpecialId(string $special_id) Return ChildRequest objects filtered by the special_id column
 * @method     ChildRequest[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RequestQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RequestQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Request', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRequestQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRequestQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRequestQuery) {
            return $criteria;
        }
        $query = new ChildRequestQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRequest|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RequestTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RequestTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRequest A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, person_name, special_id FROM request WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRequest $obj */
            $obj = new ChildRequest();
            $obj->hydrate($row);
            RequestTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRequest|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RequestTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RequestTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RequestTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RequestTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the person_name column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonName('fooValue');   // WHERE person_name = 'fooValue'
     * $query->filterByPersonName('%fooValue%', Criteria::LIKE); // WHERE person_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $personName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function filterByPersonName($personName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($personName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestTableMap::COL_PERSON_NAME, $personName, $comparison);
    }

    /**
     * Filter the query on the special_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecialId('fooValue');   // WHERE special_id = 'fooValue'
     * $query->filterBySpecialId('%fooValue%', Criteria::LIKE); // WHERE special_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $specialId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function filterBySpecialId($specialId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($specialId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestTableMap::COL_SPECIAL_ID, $specialId, $comparison);
    }

    /**
     * Filter the query by a related \ComboRequest object
     *
     * @param \ComboRequest|ObjectCollection $comboRequest the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRequestQuery The current query, for fluid interface
     */
    public function filterByComboRequest($comboRequest, $comparison = null)
    {
        if ($comboRequest instanceof \ComboRequest) {
            return $this
                ->addUsingAlias(RequestTableMap::COL_ID, $comboRequest->getRequestId(), $comparison);
        } elseif ($comboRequest instanceof ObjectCollection) {
            return $this
                ->useComboRequestQuery()
                ->filterByPrimaryKeys($comboRequest->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComboRequest() only accepts arguments of type \ComboRequest or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ComboRequest relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function joinComboRequest($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ComboRequest');

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
            $this->addJoinObject($join, 'ComboRequest');
        }

        return $this;
    }

    /**
     * Use the ComboRequest relation ComboRequest object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ComboRequestQuery A secondary query class using the current class as primary query
     */
    public function useComboRequestQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComboRequest($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ComboRequest', '\ComboRequestQuery');
    }

    /**
     * Filter the query by a related \RequestFood object
     *
     * @param \RequestFood|ObjectCollection $requestFood the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRequestQuery The current query, for fluid interface
     */
    public function filterByRequestFood($requestFood, $comparison = null)
    {
        if ($requestFood instanceof \RequestFood) {
            return $this
                ->addUsingAlias(RequestTableMap::COL_ID, $requestFood->getRequestId(), $comparison);
        } elseif ($requestFood instanceof ObjectCollection) {
            return $this
                ->useRequestFoodQuery()
                ->filterByPrimaryKeys($requestFood->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRequestFood() only accepts arguments of type \RequestFood or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RequestFood relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function joinRequestFood($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RequestFood');

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
            $this->addJoinObject($join, 'RequestFood');
        }

        return $this;
    }

    /**
     * Use the RequestFood relation RequestFood object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RequestFoodQuery A secondary query class using the current class as primary query
     */
    public function useRequestFoodQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRequestFood($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RequestFood', '\RequestFoodQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRequest $request Object to remove from the list of results
     *
     * @return $this|ChildRequestQuery The current query, for fluid interface
     */
    public function prune($request = null)
    {
        if ($request) {
            $this->addUsingAlias(RequestTableMap::COL_ID, $request->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the request table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RequestTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RequestTableMap::clearInstancePool();
            RequestTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RequestTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RequestTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RequestTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RequestTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RequestQuery
