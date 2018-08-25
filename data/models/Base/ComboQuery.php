<?php

namespace Base;

use \Combo as ChildCombo;
use \ComboQuery as ChildComboQuery;
use \Exception;
use \PDO;
use Map\ComboTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'combo' table.
 *
 *
 *
 * @method     ChildComboQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildComboQuery orderByPrice($order = Criteria::ASC) Order by the price column
 *
 * @method     ChildComboQuery groupById() Group by the id column
 * @method     ChildComboQuery groupByPrice() Group by the price column
 *
 * @method     ChildComboQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildComboQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildComboQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildComboQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildComboQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildComboQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildComboQuery leftJoinComboFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the ComboFood relation
 * @method     ChildComboQuery rightJoinComboFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ComboFood relation
 * @method     ChildComboQuery innerJoinComboFood($relationAlias = null) Adds a INNER JOIN clause to the query using the ComboFood relation
 *
 * @method     ChildComboQuery joinWithComboFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ComboFood relation
 *
 * @method     ChildComboQuery leftJoinWithComboFood() Adds a LEFT JOIN clause and with to the query using the ComboFood relation
 * @method     ChildComboQuery rightJoinWithComboFood() Adds a RIGHT JOIN clause and with to the query using the ComboFood relation
 * @method     ChildComboQuery innerJoinWithComboFood() Adds a INNER JOIN clause and with to the query using the ComboFood relation
 *
 * @method     ChildComboQuery leftJoinComboRequest($relationAlias = null) Adds a LEFT JOIN clause to the query using the ComboRequest relation
 * @method     ChildComboQuery rightJoinComboRequest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ComboRequest relation
 * @method     ChildComboQuery innerJoinComboRequest($relationAlias = null) Adds a INNER JOIN clause to the query using the ComboRequest relation
 *
 * @method     ChildComboQuery joinWithComboRequest($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ComboRequest relation
 *
 * @method     ChildComboQuery leftJoinWithComboRequest() Adds a LEFT JOIN clause and with to the query using the ComboRequest relation
 * @method     ChildComboQuery rightJoinWithComboRequest() Adds a RIGHT JOIN clause and with to the query using the ComboRequest relation
 * @method     ChildComboQuery innerJoinWithComboRequest() Adds a INNER JOIN clause and with to the query using the ComboRequest relation
 *
 * @method     \ComboFoodQuery|\ComboRequestQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCombo findOne(ConnectionInterface $con = null) Return the first ChildCombo matching the query
 * @method     ChildCombo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCombo matching the query, or a new ChildCombo object populated from the query conditions when no match is found
 *
 * @method     ChildCombo findOneById(int $id) Return the first ChildCombo filtered by the id column
 * @method     ChildCombo findOneByPrice(double $price) Return the first ChildCombo filtered by the price column *

 * @method     ChildCombo requirePk($key, ConnectionInterface $con = null) Return the ChildCombo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCombo requireOne(ConnectionInterface $con = null) Return the first ChildCombo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCombo requireOneById(int $id) Return the first ChildCombo filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCombo requireOneByPrice(double $price) Return the first ChildCombo filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCombo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCombo objects based on current ModelCriteria
 * @method     ChildCombo[]|ObjectCollection findById(int $id) Return ChildCombo objects filtered by the id column
 * @method     ChildCombo[]|ObjectCollection findByPrice(double $price) Return ChildCombo objects filtered by the price column
 * @method     ChildCombo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ComboQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ComboQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Combo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildComboQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildComboQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildComboQuery) {
            return $criteria;
        }
        $query = new ChildComboQuery();
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
     * @return ChildCombo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ComboTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ComboTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCombo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, price FROM combo WHERE id = :p0';
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
            /** @var ChildCombo $obj */
            $obj = new ChildCombo();
            $obj->hydrate($row);
            ComboTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCombo|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ComboTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ComboTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ComboTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ComboTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(ComboTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(ComboTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ComboTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query by a related \ComboFood object
     *
     * @param \ComboFood|ObjectCollection $comboFood the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComboQuery The current query, for fluid interface
     */
    public function filterByComboFood($comboFood, $comparison = null)
    {
        if ($comboFood instanceof \ComboFood) {
            return $this
                ->addUsingAlias(ComboTableMap::COL_ID, $comboFood->getComboId(), $comparison);
        } elseif ($comboFood instanceof ObjectCollection) {
            return $this
                ->useComboFoodQuery()
                ->filterByPrimaryKeys($comboFood->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComboFood() only accepts arguments of type \ComboFood or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ComboFood relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function joinComboFood($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ComboFood');

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
            $this->addJoinObject($join, 'ComboFood');
        }

        return $this;
    }

    /**
     * Use the ComboFood relation ComboFood object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ComboFoodQuery A secondary query class using the current class as primary query
     */
    public function useComboFoodQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComboFood($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ComboFood', '\ComboFoodQuery');
    }

    /**
     * Filter the query by a related \ComboRequest object
     *
     * @param \ComboRequest|ObjectCollection $comboRequest the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildComboQuery The current query, for fluid interface
     */
    public function filterByComboRequest($comboRequest, $comparison = null)
    {
        if ($comboRequest instanceof \ComboRequest) {
            return $this
                ->addUsingAlias(ComboTableMap::COL_ID, $comboRequest->getComboId(), $comparison);
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
     * @return $this|ChildComboQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCombo $combo Object to remove from the list of results
     *
     * @return $this|ChildComboQuery The current query, for fluid interface
     */
    public function prune($combo = null)
    {
        if ($combo) {
            $this->addUsingAlias(ComboTableMap::COL_ID, $combo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the combo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ComboTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ComboTableMap::clearInstancePool();
            ComboTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ComboTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ComboTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ComboTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ComboTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ComboQuery
