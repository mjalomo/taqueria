<?php

namespace Base;

use \Food as ChildFood;
use \FoodQuery as ChildFoodQuery;
use \Exception;
use \PDO;
use Map\FoodTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'food' table.
 *
 *
 *
 * @method     ChildFoodQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFoodQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildFoodQuery orderByPrice($order = Criteria::ASC) Order by the price column
 *
 * @method     ChildFoodQuery groupById() Group by the id column
 * @method     ChildFoodQuery groupByName() Group by the name column
 * @method     ChildFoodQuery groupByPrice() Group by the price column
 *
 * @method     ChildFoodQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFoodQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFoodQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFoodQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFoodQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFoodQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFoodQuery leftJoinComboFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the ComboFood relation
 * @method     ChildFoodQuery rightJoinComboFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ComboFood relation
 * @method     ChildFoodQuery innerJoinComboFood($relationAlias = null) Adds a INNER JOIN clause to the query using the ComboFood relation
 *
 * @method     ChildFoodQuery joinWithComboFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ComboFood relation
 *
 * @method     ChildFoodQuery leftJoinWithComboFood() Adds a LEFT JOIN clause and with to the query using the ComboFood relation
 * @method     ChildFoodQuery rightJoinWithComboFood() Adds a RIGHT JOIN clause and with to the query using the ComboFood relation
 * @method     ChildFoodQuery innerJoinWithComboFood() Adds a INNER JOIN clause and with to the query using the ComboFood relation
 *
 * @method     ChildFoodQuery leftJoinRequestFood($relationAlias = null) Adds a LEFT JOIN clause to the query using the RequestFood relation
 * @method     ChildFoodQuery rightJoinRequestFood($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RequestFood relation
 * @method     ChildFoodQuery innerJoinRequestFood($relationAlias = null) Adds a INNER JOIN clause to the query using the RequestFood relation
 *
 * @method     ChildFoodQuery joinWithRequestFood($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RequestFood relation
 *
 * @method     ChildFoodQuery leftJoinWithRequestFood() Adds a LEFT JOIN clause and with to the query using the RequestFood relation
 * @method     ChildFoodQuery rightJoinWithRequestFood() Adds a RIGHT JOIN clause and with to the query using the RequestFood relation
 * @method     ChildFoodQuery innerJoinWithRequestFood() Adds a INNER JOIN clause and with to the query using the RequestFood relation
 *
 * @method     \ComboFoodQuery|\RequestFoodQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFood findOne(ConnectionInterface $con = null) Return the first ChildFood matching the query
 * @method     ChildFood findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFood matching the query, or a new ChildFood object populated from the query conditions when no match is found
 *
 * @method     ChildFood findOneById(int $id) Return the first ChildFood filtered by the id column
 * @method     ChildFood findOneByName(string $name) Return the first ChildFood filtered by the name column
 * @method     ChildFood findOneByPrice(double $price) Return the first ChildFood filtered by the price column *

 * @method     ChildFood requirePk($key, ConnectionInterface $con = null) Return the ChildFood by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFood requireOne(ConnectionInterface $con = null) Return the first ChildFood matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFood requireOneById(int $id) Return the first ChildFood filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFood requireOneByName(string $name) Return the first ChildFood filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFood requireOneByPrice(double $price) Return the first ChildFood filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFood[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFood objects based on current ModelCriteria
 * @method     ChildFood[]|ObjectCollection findById(int $id) Return ChildFood objects filtered by the id column
 * @method     ChildFood[]|ObjectCollection findByName(string $name) Return ChildFood objects filtered by the name column
 * @method     ChildFood[]|ObjectCollection findByPrice(double $price) Return ChildFood objects filtered by the price column
 * @method     ChildFood[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FoodQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FoodQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Food', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFoodQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFoodQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFoodQuery) {
            return $criteria;
        }
        $query = new ChildFoodQuery();
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
     * @return ChildFood|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FoodTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FoodTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFood A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, price FROM food WHERE id = :p0';
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
            /** @var ChildFood $obj */
            $obj = new ChildFood();
            $obj->hydrate($row);
            FoodTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFood|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FoodTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FoodTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FoodTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FoodTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FoodTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FoodTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(FoodTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(FoodTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FoodTableMap::COL_PRICE, $price, $comparison);
    }

    /**
     * Filter the query by a related \ComboFood object
     *
     * @param \ComboFood|ObjectCollection $comboFood the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFoodQuery The current query, for fluid interface
     */
    public function filterByComboFood($comboFood, $comparison = null)
    {
        if ($comboFood instanceof \ComboFood) {
            return $this
                ->addUsingAlias(FoodTableMap::COL_ID, $comboFood->getFoodId(), $comparison);
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
     * @return $this|ChildFoodQuery The current query, for fluid interface
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
     * Filter the query by a related \RequestFood object
     *
     * @param \RequestFood|ObjectCollection $requestFood the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFoodQuery The current query, for fluid interface
     */
    public function filterByRequestFood($requestFood, $comparison = null)
    {
        if ($requestFood instanceof \RequestFood) {
            return $this
                ->addUsingAlias(FoodTableMap::COL_ID, $requestFood->getFoodId(), $comparison);
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
     * @return $this|ChildFoodQuery The current query, for fluid interface
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
     * Filter the query by a related Combo object
     * using the combo_food table as cross reference
     *
     * @param Combo $combo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFoodQuery The current query, for fluid interface
     */
    public function filterByCombo($combo, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useComboFoodQuery()
            ->filterByCombo($combo, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Request object
     * using the request_food table as cross reference
     *
     * @param Request $request the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFoodQuery The current query, for fluid interface
     */
    public function filterByRequest($request, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRequestFoodQuery()
            ->filterByRequest($request, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFood $food Object to remove from the list of results
     *
     * @return $this|ChildFoodQuery The current query, for fluid interface
     */
    public function prune($food = null)
    {
        if ($food) {
            $this->addUsingAlias(FoodTableMap::COL_ID, $food->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the food table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FoodTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FoodTableMap::clearInstancePool();
            FoodTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FoodTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FoodTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FoodTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FoodTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FoodQuery
