<?php

namespace Base;

use \ComboRequest as ChildComboRequest;
use \ComboRequestQuery as ChildComboRequestQuery;
use \Exception;
use \PDO;
use Map\ComboRequestTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'combo_request' table.
 *
 *
 *
 * @method     ChildComboRequestQuery orderByComboId($order = Criteria::ASC) Order by the combo_id column
 * @method     ChildComboRequestQuery orderByRequestId($order = Criteria::ASC) Order by the request_id column
 *
 * @method     ChildComboRequestQuery groupByComboId() Group by the combo_id column
 * @method     ChildComboRequestQuery groupByRequestId() Group by the request_id column
 *
 * @method     ChildComboRequestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildComboRequestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildComboRequestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComboRequestQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildComboRequestQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildComboRequestQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildComboRequestQuery leftJoinCombo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Combo relation
 * @method     ChildComboRequestQuery rightJoinCombo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Combo relation
 * @method     ChildComboRequestQuery innerJoinCombo($relationAlias = null) Adds a INNER JOIN clause to the query using the Combo relation
 *
 * @method     ChildComboRequestQuery joinWithCombo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Combo relation
 *
 * @method     ChildComboRequestQuery leftJoinWithCombo() Adds a LEFT JOIN clause and with to the query using the Combo relation
 * @method     ChildComboRequestQuery rightJoinWithCombo() Adds a RIGHT JOIN clause and with to the query using the Combo relation
 * @method     ChildComboRequestQuery innerJoinWithCombo() Adds a INNER JOIN clause and with to the query using the Combo relation
 *
 * @method     ChildComboRequestQuery leftJoinRequest($relationAlias = null) Adds a LEFT JOIN clause to the query using the Request relation
 * @method     ChildComboRequestQuery rightJoinRequest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Request relation
 * @method     ChildComboRequestQuery innerJoinRequest($relationAlias = null) Adds a INNER JOIN clause to the query using the Request relation
 *
 * @method     ChildComboRequestQuery joinWithRequest($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Request relation
 *
 * @method     ChildComboRequestQuery leftJoinWithRequest() Adds a LEFT JOIN clause and with to the query using the Request relation
 * @method     ChildComboRequestQuery rightJoinWithRequest() Adds a RIGHT JOIN clause and with to the query using the Request relation
 * @method     ChildComboRequestQuery innerJoinWithRequest() Adds a INNER JOIN clause and with to the query using the Request relation
 *
 * @method     \ComboQuery|\RequestQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComboRequest findOne(ConnectionInterface $con = null) Return the first ChildComboRequest matching the query
 * @method     ChildComboRequest findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComboRequest matching the query, or a new ChildComboRequest object populated from the query conditions when no match is found
 *
 * @method     ChildComboRequest findOneByComboId(int $combo_id) Return the first ChildComboRequest filtered by the combo_id column
 * @method     ChildComboRequest findOneByRequestId(int $request_id) Return the first ChildComboRequest filtered by the request_id column *

 * @method     ChildComboRequest requirePk($key, ConnectionInterface $con = null) Return the ChildComboRequest by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComboRequest requireOne(ConnectionInterface $con = null) Return the first ChildComboRequest matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComboRequest requireOneByComboId(int $combo_id) Return the first ChildComboRequest filtered by the combo_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComboRequest requireOneByRequestId(int $request_id) Return the first ChildComboRequest filtered by the request_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComboRequest[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComboRequest objects based on current ModelCriteria
 * @method     ChildComboRequest[]|ObjectCollection findByComboId(int $combo_id) Return ChildComboRequest objects filtered by the combo_id column
 * @method     ChildComboRequest[]|ObjectCollection findByRequestId(int $request_id) Return ChildComboRequest objects filtered by the request_id column
 * @method     ChildComboRequest[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ComboRequestQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ComboRequestQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ComboRequest', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildComboRequestQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildComboRequestQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildComboRequestQuery) {
            return $criteria;
        }
        $query = new ChildComboRequestQuery();
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
     * @param array[$combo_id, $request_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildComboRequest|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComboRequestTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ComboRequestTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildComboRequest A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT combo_id, request_id FROM combo_request WHERE combo_id = :p0 AND request_id = :p1';
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
            /** @var ChildComboRequest $obj */
            $obj = new ChildComboRequest();
            $obj->hydrate($row);
            ComboRequestTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildComboRequest|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ComboRequestTableMap::COL_COMBO_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ComboRequestTableMap::COL_REQUEST_ID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByComboId($comboId = null, $comparison = null)
    {
        if (is_array($comboId)) {
            $useMinMax = false;
            if (isset($comboId['min'])) {
                $this->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $comboId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($comboId['max'])) {
                $this->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $comboId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $comboId, $comparison);
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
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByRequestId($requestId = null, $comparison = null)
    {
        if (is_array($requestId)) {
            $useMinMax = false;
            if (isset($requestId['min'])) {
                $this->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $requestId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requestId['max'])) {
                $this->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $requestId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $requestId, $comparison);
    }

    /**
     * Filter the query by a related \Combo object
     *
     * @param \Combo|ObjectCollection $combo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByCombo($combo, $comparison = null)
    {
        if ($combo instanceof \Combo) {
            return $this
                ->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $combo->getId(), $comparison);
        } elseif ($combo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComboRequestTableMap::COL_COMBO_ID, $combo->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
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
     * Filter the query by a related \Request object
     *
     * @param \Request|ObjectCollection $request The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComboRequestQuery The current query, for fluid interface
     */
    public function filterByRequest($request, $comparison = null)
    {
        if ($request instanceof \Request) {
            return $this
                ->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $request->getId(), $comparison);
        } elseif ($request instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ComboRequestTableMap::COL_REQUEST_ID, $request->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildComboRequest $comboRequest Object to remove from the list of results
     *
     * @return $this|ChildComboRequestQuery The current query, for fluid interface
     */
    public function prune($comboRequest = null)
    {
        if ($comboRequest) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ComboRequestTableMap::COL_COMBO_ID), $comboRequest->getComboId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ComboRequestTableMap::COL_REQUEST_ID), $comboRequest->getRequestId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the combo_request table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComboRequestTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ComboRequestTableMap::clearInstancePool();
            ComboRequestTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ComboRequestTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ComboRequestTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ComboRequestTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ComboRequestTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ComboRequestQuery
