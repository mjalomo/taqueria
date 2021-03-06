<?php

namespace Base;

use \Combo as ChildCombo;
use \ComboFood as ChildComboFood;
use \ComboFoodQuery as ChildComboFoodQuery;
use \ComboQuery as ChildComboQuery;
use \Food as ChildFood;
use \FoodQuery as ChildFoodQuery;
use \Request as ChildRequest;
use \RequestFood as ChildRequestFood;
use \RequestFoodQuery as ChildRequestFoodQuery;
use \RequestQuery as ChildRequestQuery;
use \Exception;
use \PDO;
use Map\ComboFoodTableMap;
use Map\FoodTableMap;
use Map\RequestFoodTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'food' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Food implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\FoodTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the price field.
     *
     * @var        double
     */
    protected $price;

    /**
     * @var        ObjectCollection|ChildComboFood[] Collection to store aggregation of ChildComboFood objects.
     */
    protected $collComboFoods;
    protected $collComboFoodsPartial;

    /**
     * @var        ObjectCollection|ChildRequestFood[] Collection to store aggregation of ChildRequestFood objects.
     */
    protected $collRequestFoods;
    protected $collRequestFoodsPartial;

    /**
     * @var        ObjectCollection|ChildCombo[] Cross Collection to store aggregation of ChildCombo objects.
     */
    protected $collCombos;

    /**
     * @var bool
     */
    protected $collCombosPartial;

    /**
     * @var        ObjectCollection|ChildRequest[] Cross Collection to store aggregation of ChildRequest objects.
     */
    protected $collRequests;

    /**
     * @var bool
     */
    protected $collRequestsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCombo[]
     */
    protected $combosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRequest[]
     */
    protected $requestsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComboFood[]
     */
    protected $comboFoodsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRequestFood[]
     */
    protected $requestFoodsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Food object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Food</code> instance.  If
     * <code>obj</code> is an instance of <code>Food</code>, delegates to
     * <code>equals(Food)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Food The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [price] column value.
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Food The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FoodTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Food The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[FoodTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [price] column.
     *
     * @param double $v new value
     * @return $this|\Food The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[FoodTableMap::COL_PRICE] = true;
        }

        return $this;
    } // setPrice()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FoodTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FoodTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FoodTableMap::translateFieldName('Price', TableMap::TYPE_PHPNAME, $indexType)];
            $this->price = (null !== $col) ? (double) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = FoodTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Food'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FoodTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFoodQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collComboFoods = null;

            $this->collRequestFoods = null;

            $this->collCombos = null;
            $this->collRequests = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Food::setDeleted()
     * @see Food::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FoodTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFoodQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FoodTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                FoodTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->combosScheduledForDeletion !== null) {
                if (!$this->combosScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->combosScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ComboFoodQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->combosScheduledForDeletion = null;
                }

            }

            if ($this->collCombos) {
                foreach ($this->collCombos as $combo) {
                    if (!$combo->isDeleted() && ($combo->isNew() || $combo->isModified())) {
                        $combo->save($con);
                    }
                }
            }


            if ($this->requestsScheduledForDeletion !== null) {
                if (!$this->requestsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->requestsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RequestFoodQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->requestsScheduledForDeletion = null;
                }

            }

            if ($this->collRequests) {
                foreach ($this->collRequests as $request) {
                    if (!$request->isDeleted() && ($request->isNew() || $request->isModified())) {
                        $request->save($con);
                    }
                }
            }


            if ($this->comboFoodsScheduledForDeletion !== null) {
                if (!$this->comboFoodsScheduledForDeletion->isEmpty()) {
                    \ComboFoodQuery::create()
                        ->filterByPrimaryKeys($this->comboFoodsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->comboFoodsScheduledForDeletion = null;
                }
            }

            if ($this->collComboFoods !== null) {
                foreach ($this->collComboFoods as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->requestFoodsScheduledForDeletion !== null) {
                if (!$this->requestFoodsScheduledForDeletion->isEmpty()) {
                    \RequestFoodQuery::create()
                        ->filterByPrimaryKeys($this->requestFoodsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->requestFoodsScheduledForDeletion = null;
                }
            }

            if ($this->collRequestFoods !== null) {
                foreach ($this->collRequestFoods as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[FoodTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FoodTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FoodTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(FoodTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(FoodTableMap::COL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'price';
        }

        $sql = sprintf(
            'INSERT INTO food (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'price':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FoodTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getPrice();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Food'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Food'][$this->hashCode()] = true;
        $keys = FoodTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getPrice(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collComboFoods) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comboFoods';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'combo_foods';
                        break;
                    default:
                        $key = 'ComboFoods';
                }

                $result[$key] = $this->collComboFoods->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRequestFoods) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'requestFoods';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'request_foods';
                        break;
                    default:
                        $key = 'RequestFoods';
                }

                $result[$key] = $this->collRequestFoods->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Food
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FoodTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Food
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setPrice($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = FoodTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPrice($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Food The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FoodTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FoodTableMap::COL_ID)) {
            $criteria->add(FoodTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(FoodTableMap::COL_NAME)) {
            $criteria->add(FoodTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(FoodTableMap::COL_PRICE)) {
            $criteria->add(FoodTableMap::COL_PRICE, $this->price);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildFoodQuery::create();
        $criteria->add(FoodTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Food (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setPrice($this->getPrice());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getComboFoods() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComboFood($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRequestFoods() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRequestFood($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Food Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ComboFood' == $relationName) {
            $this->initComboFoods();
            return;
        }
        if ('RequestFood' == $relationName) {
            $this->initRequestFoods();
            return;
        }
    }

    /**
     * Clears out the collComboFoods collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComboFoods()
     */
    public function clearComboFoods()
    {
        $this->collComboFoods = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collComboFoods collection loaded partially.
     */
    public function resetPartialComboFoods($v = true)
    {
        $this->collComboFoodsPartial = $v;
    }

    /**
     * Initializes the collComboFoods collection.
     *
     * By default this just sets the collComboFoods collection to an empty array (like clearcollComboFoods());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComboFoods($overrideExisting = true)
    {
        if (null !== $this->collComboFoods && !$overrideExisting) {
            return;
        }

        $collectionClassName = ComboFoodTableMap::getTableMap()->getCollectionClassName();

        $this->collComboFoods = new $collectionClassName;
        $this->collComboFoods->setModel('\ComboFood');
    }

    /**
     * Gets an array of ChildComboFood objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFood is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComboFood[] List of ChildComboFood objects
     * @throws PropelException
     */
    public function getComboFoods(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collComboFoodsPartial && !$this->isNew();
        if (null === $this->collComboFoods || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComboFoods) {
                // return empty collection
                $this->initComboFoods();
            } else {
                $collComboFoods = ChildComboFoodQuery::create(null, $criteria)
                    ->filterByFood($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collComboFoodsPartial && count($collComboFoods)) {
                        $this->initComboFoods(false);

                        foreach ($collComboFoods as $obj) {
                            if (false == $this->collComboFoods->contains($obj)) {
                                $this->collComboFoods->append($obj);
                            }
                        }

                        $this->collComboFoodsPartial = true;
                    }

                    return $collComboFoods;
                }

                if ($partial && $this->collComboFoods) {
                    foreach ($this->collComboFoods as $obj) {
                        if ($obj->isNew()) {
                            $collComboFoods[] = $obj;
                        }
                    }
                }

                $this->collComboFoods = $collComboFoods;
                $this->collComboFoodsPartial = false;
            }
        }

        return $this->collComboFoods;
    }

    /**
     * Sets a collection of ChildComboFood objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $comboFoods A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function setComboFoods(Collection $comboFoods, ConnectionInterface $con = null)
    {
        /** @var ChildComboFood[] $comboFoodsToDelete */
        $comboFoodsToDelete = $this->getComboFoods(new Criteria(), $con)->diff($comboFoods);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->comboFoodsScheduledForDeletion = clone $comboFoodsToDelete;

        foreach ($comboFoodsToDelete as $comboFoodRemoved) {
            $comboFoodRemoved->setFood(null);
        }

        $this->collComboFoods = null;
        foreach ($comboFoods as $comboFood) {
            $this->addComboFood($comboFood);
        }

        $this->collComboFoods = $comboFoods;
        $this->collComboFoodsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ComboFood objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ComboFood objects.
     * @throws PropelException
     */
    public function countComboFoods(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collComboFoodsPartial && !$this->isNew();
        if (null === $this->collComboFoods || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComboFoods) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComboFoods());
            }

            $query = ChildComboFoodQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFood($this)
                ->count($con);
        }

        return count($this->collComboFoods);
    }

    /**
     * Method called to associate a ChildComboFood object to this object
     * through the ChildComboFood foreign key attribute.
     *
     * @param  ChildComboFood $l ChildComboFood
     * @return $this|\Food The current object (for fluent API support)
     */
    public function addComboFood(ChildComboFood $l)
    {
        if ($this->collComboFoods === null) {
            $this->initComboFoods();
            $this->collComboFoodsPartial = true;
        }

        if (!$this->collComboFoods->contains($l)) {
            $this->doAddComboFood($l);

            if ($this->comboFoodsScheduledForDeletion and $this->comboFoodsScheduledForDeletion->contains($l)) {
                $this->comboFoodsScheduledForDeletion->remove($this->comboFoodsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComboFood $comboFood The ChildComboFood object to add.
     */
    protected function doAddComboFood(ChildComboFood $comboFood)
    {
        $this->collComboFoods[]= $comboFood;
        $comboFood->setFood($this);
    }

    /**
     * @param  ChildComboFood $comboFood The ChildComboFood object to remove.
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function removeComboFood(ChildComboFood $comboFood)
    {
        if ($this->getComboFoods()->contains($comboFood)) {
            $pos = $this->collComboFoods->search($comboFood);
            $this->collComboFoods->remove($pos);
            if (null === $this->comboFoodsScheduledForDeletion) {
                $this->comboFoodsScheduledForDeletion = clone $this->collComboFoods;
                $this->comboFoodsScheduledForDeletion->clear();
            }
            $this->comboFoodsScheduledForDeletion[]= clone $comboFood;
            $comboFood->setFood(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Food is new, it will return
     * an empty collection; or if this Food has previously
     * been saved, it will retrieve related ComboFoods from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Food.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComboFood[] List of ChildComboFood objects
     */
    public function getComboFoodsJoinCombo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildComboFoodQuery::create(null, $criteria);
        $query->joinWith('Combo', $joinBehavior);

        return $this->getComboFoods($query, $con);
    }

    /**
     * Clears out the collRequestFoods collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRequestFoods()
     */
    public function clearRequestFoods()
    {
        $this->collRequestFoods = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRequestFoods collection loaded partially.
     */
    public function resetPartialRequestFoods($v = true)
    {
        $this->collRequestFoodsPartial = $v;
    }

    /**
     * Initializes the collRequestFoods collection.
     *
     * By default this just sets the collRequestFoods collection to an empty array (like clearcollRequestFoods());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRequestFoods($overrideExisting = true)
    {
        if (null !== $this->collRequestFoods && !$overrideExisting) {
            return;
        }

        $collectionClassName = RequestFoodTableMap::getTableMap()->getCollectionClassName();

        $this->collRequestFoods = new $collectionClassName;
        $this->collRequestFoods->setModel('\RequestFood');
    }

    /**
     * Gets an array of ChildRequestFood objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFood is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRequestFood[] List of ChildRequestFood objects
     * @throws PropelException
     */
    public function getRequestFoods(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestFoodsPartial && !$this->isNew();
        if (null === $this->collRequestFoods || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRequestFoods) {
                // return empty collection
                $this->initRequestFoods();
            } else {
                $collRequestFoods = ChildRequestFoodQuery::create(null, $criteria)
                    ->filterByFood($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRequestFoodsPartial && count($collRequestFoods)) {
                        $this->initRequestFoods(false);

                        foreach ($collRequestFoods as $obj) {
                            if (false == $this->collRequestFoods->contains($obj)) {
                                $this->collRequestFoods->append($obj);
                            }
                        }

                        $this->collRequestFoodsPartial = true;
                    }

                    return $collRequestFoods;
                }

                if ($partial && $this->collRequestFoods) {
                    foreach ($this->collRequestFoods as $obj) {
                        if ($obj->isNew()) {
                            $collRequestFoods[] = $obj;
                        }
                    }
                }

                $this->collRequestFoods = $collRequestFoods;
                $this->collRequestFoodsPartial = false;
            }
        }

        return $this->collRequestFoods;
    }

    /**
     * Sets a collection of ChildRequestFood objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $requestFoods A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function setRequestFoods(Collection $requestFoods, ConnectionInterface $con = null)
    {
        /** @var ChildRequestFood[] $requestFoodsToDelete */
        $requestFoodsToDelete = $this->getRequestFoods(new Criteria(), $con)->diff($requestFoods);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->requestFoodsScheduledForDeletion = clone $requestFoodsToDelete;

        foreach ($requestFoodsToDelete as $requestFoodRemoved) {
            $requestFoodRemoved->setFood(null);
        }

        $this->collRequestFoods = null;
        foreach ($requestFoods as $requestFood) {
            $this->addRequestFood($requestFood);
        }

        $this->collRequestFoods = $requestFoods;
        $this->collRequestFoodsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RequestFood objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RequestFood objects.
     * @throws PropelException
     */
    public function countRequestFoods(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestFoodsPartial && !$this->isNew();
        if (null === $this->collRequestFoods || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRequestFoods) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRequestFoods());
            }

            $query = ChildRequestFoodQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFood($this)
                ->count($con);
        }

        return count($this->collRequestFoods);
    }

    /**
     * Method called to associate a ChildRequestFood object to this object
     * through the ChildRequestFood foreign key attribute.
     *
     * @param  ChildRequestFood $l ChildRequestFood
     * @return $this|\Food The current object (for fluent API support)
     */
    public function addRequestFood(ChildRequestFood $l)
    {
        if ($this->collRequestFoods === null) {
            $this->initRequestFoods();
            $this->collRequestFoodsPartial = true;
        }

        if (!$this->collRequestFoods->contains($l)) {
            $this->doAddRequestFood($l);

            if ($this->requestFoodsScheduledForDeletion and $this->requestFoodsScheduledForDeletion->contains($l)) {
                $this->requestFoodsScheduledForDeletion->remove($this->requestFoodsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRequestFood $requestFood The ChildRequestFood object to add.
     */
    protected function doAddRequestFood(ChildRequestFood $requestFood)
    {
        $this->collRequestFoods[]= $requestFood;
        $requestFood->setFood($this);
    }

    /**
     * @param  ChildRequestFood $requestFood The ChildRequestFood object to remove.
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function removeRequestFood(ChildRequestFood $requestFood)
    {
        if ($this->getRequestFoods()->contains($requestFood)) {
            $pos = $this->collRequestFoods->search($requestFood);
            $this->collRequestFoods->remove($pos);
            if (null === $this->requestFoodsScheduledForDeletion) {
                $this->requestFoodsScheduledForDeletion = clone $this->collRequestFoods;
                $this->requestFoodsScheduledForDeletion->clear();
            }
            $this->requestFoodsScheduledForDeletion[]= clone $requestFood;
            $requestFood->setFood(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Food is new, it will return
     * an empty collection; or if this Food has previously
     * been saved, it will retrieve related RequestFoods from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Food.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRequestFood[] List of ChildRequestFood objects
     */
    public function getRequestFoodsJoinRequest(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRequestFoodQuery::create(null, $criteria);
        $query->joinWith('Request', $joinBehavior);

        return $this->getRequestFoods($query, $con);
    }

    /**
     * Clears out the collCombos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCombos()
     */
    public function clearCombos()
    {
        $this->collCombos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collCombos crossRef collection.
     *
     * By default this just sets the collCombos collection to an empty collection (like clearCombos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initCombos()
    {
        $collectionClassName = ComboFoodTableMap::getTableMap()->getCollectionClassName();

        $this->collCombos = new $collectionClassName;
        $this->collCombosPartial = true;
        $this->collCombos->setModel('\Combo');
    }

    /**
     * Checks if the collCombos collection is loaded.
     *
     * @return bool
     */
    public function isCombosLoaded()
    {
        return null !== $this->collCombos;
    }

    /**
     * Gets a collection of ChildCombo objects related by a many-to-many relationship
     * to the current object by way of the combo_food cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFood is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildCombo[] List of ChildCombo objects
     */
    public function getCombos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCombosPartial && !$this->isNew();
        if (null === $this->collCombos || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collCombos) {
                    $this->initCombos();
                }
            } else {

                $query = ChildComboQuery::create(null, $criteria)
                    ->filterByFood($this);
                $collCombos = $query->find($con);
                if (null !== $criteria) {
                    return $collCombos;
                }

                if ($partial && $this->collCombos) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collCombos as $obj) {
                        if (!$collCombos->contains($obj)) {
                            $collCombos[] = $obj;
                        }
                    }
                }

                $this->collCombos = $collCombos;
                $this->collCombosPartial = false;
            }
        }

        return $this->collCombos;
    }

    /**
     * Sets a collection of Combo objects related by a many-to-many relationship
     * to the current object by way of the combo_food cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $combos A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function setCombos(Collection $combos, ConnectionInterface $con = null)
    {
        $this->clearCombos();
        $currentCombos = $this->getCombos();

        $combosScheduledForDeletion = $currentCombos->diff($combos);

        foreach ($combosScheduledForDeletion as $toDelete) {
            $this->removeCombo($toDelete);
        }

        foreach ($combos as $combo) {
            if (!$currentCombos->contains($combo)) {
                $this->doAddCombo($combo);
            }
        }

        $this->collCombosPartial = false;
        $this->collCombos = $combos;

        return $this;
    }

    /**
     * Gets the number of Combo objects related by a many-to-many relationship
     * to the current object by way of the combo_food cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Combo objects
     */
    public function countCombos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCombosPartial && !$this->isNew();
        if (null === $this->collCombos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCombos) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getCombos());
                }

                $query = ChildComboQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByFood($this)
                    ->count($con);
            }
        } else {
            return count($this->collCombos);
        }
    }

    /**
     * Associate a ChildCombo to this object
     * through the combo_food cross reference table.
     *
     * @param ChildCombo $combo
     * @return ChildFood The current object (for fluent API support)
     */
    public function addCombo(ChildCombo $combo)
    {
        if ($this->collCombos === null) {
            $this->initCombos();
        }

        if (!$this->getCombos()->contains($combo)) {
            // only add it if the **same** object is not already associated
            $this->collCombos->push($combo);
            $this->doAddCombo($combo);
        }

        return $this;
    }

    /**
     *
     * @param ChildCombo $combo
     */
    protected function doAddCombo(ChildCombo $combo)
    {
        $comboFood = new ChildComboFood();

        $comboFood->setCombo($combo);

        $comboFood->setFood($this);

        $this->addComboFood($comboFood);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$combo->isFoodsLoaded()) {
            $combo->initFoods();
            $combo->getFoods()->push($this);
        } elseif (!$combo->getFoods()->contains($this)) {
            $combo->getFoods()->push($this);
        }

    }

    /**
     * Remove combo of this object
     * through the combo_food cross reference table.
     *
     * @param ChildCombo $combo
     * @return ChildFood The current object (for fluent API support)
     */
    public function removeCombo(ChildCombo $combo)
    {
        if ($this->getCombos()->contains($combo)) {
            $comboFood = new ChildComboFood();
            $comboFood->setCombo($combo);
            if ($combo->isFoodsLoaded()) {
                //remove the back reference if available
                $combo->getFoods()->removeObject($this);
            }

            $comboFood->setFood($this);
            $this->removeComboFood(clone $comboFood);
            $comboFood->clear();

            $this->collCombos->remove($this->collCombos->search($combo));

            if (null === $this->combosScheduledForDeletion) {
                $this->combosScheduledForDeletion = clone $this->collCombos;
                $this->combosScheduledForDeletion->clear();
            }

            $this->combosScheduledForDeletion->push($combo);
        }


        return $this;
    }

    /**
     * Clears out the collRequests collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRequests()
     */
    public function clearRequests()
    {
        $this->collRequests = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRequests crossRef collection.
     *
     * By default this just sets the collRequests collection to an empty collection (like clearRequests());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRequests()
    {
        $collectionClassName = RequestFoodTableMap::getTableMap()->getCollectionClassName();

        $this->collRequests = new $collectionClassName;
        $this->collRequestsPartial = true;
        $this->collRequests->setModel('\Request');
    }

    /**
     * Checks if the collRequests collection is loaded.
     *
     * @return bool
     */
    public function isRequestsLoaded()
    {
        return null !== $this->collRequests;
    }

    /**
     * Gets a collection of ChildRequest objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildFood is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildRequest[] List of ChildRequest objects
     */
    public function getRequests(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestsPartial && !$this->isNew();
        if (null === $this->collRequests || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRequests) {
                    $this->initRequests();
                }
            } else {

                $query = ChildRequestQuery::create(null, $criteria)
                    ->filterByFood($this);
                $collRequests = $query->find($con);
                if (null !== $criteria) {
                    return $collRequests;
                }

                if ($partial && $this->collRequests) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRequests as $obj) {
                        if (!$collRequests->contains($obj)) {
                            $collRequests[] = $obj;
                        }
                    }
                }

                $this->collRequests = $collRequests;
                $this->collRequestsPartial = false;
            }
        }

        return $this->collRequests;
    }

    /**
     * Sets a collection of Request objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $requests A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildFood The current object (for fluent API support)
     */
    public function setRequests(Collection $requests, ConnectionInterface $con = null)
    {
        $this->clearRequests();
        $currentRequests = $this->getRequests();

        $requestsScheduledForDeletion = $currentRequests->diff($requests);

        foreach ($requestsScheduledForDeletion as $toDelete) {
            $this->removeRequest($toDelete);
        }

        foreach ($requests as $request) {
            if (!$currentRequests->contains($request)) {
                $this->doAddRequest($request);
            }
        }

        $this->collRequestsPartial = false;
        $this->collRequests = $requests;

        return $this;
    }

    /**
     * Gets the number of Request objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Request objects
     */
    public function countRequests(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestsPartial && !$this->isNew();
        if (null === $this->collRequests || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRequests) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRequests());
                }

                $query = ChildRequestQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByFood($this)
                    ->count($con);
            }
        } else {
            return count($this->collRequests);
        }
    }

    /**
     * Associate a ChildRequest to this object
     * through the request_food cross reference table.
     *
     * @param ChildRequest $request
     * @return ChildFood The current object (for fluent API support)
     */
    public function addRequest(ChildRequest $request)
    {
        if ($this->collRequests === null) {
            $this->initRequests();
        }

        if (!$this->getRequests()->contains($request)) {
            // only add it if the **same** object is not already associated
            $this->collRequests->push($request);
            $this->doAddRequest($request);
        }

        return $this;
    }

    /**
     *
     * @param ChildRequest $request
     */
    protected function doAddRequest(ChildRequest $request)
    {
        $requestFood = new ChildRequestFood();

        $requestFood->setRequest($request);

        $requestFood->setFood($this);

        $this->addRequestFood($requestFood);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$request->isFoodsLoaded()) {
            $request->initFoods();
            $request->getFoods()->push($this);
        } elseif (!$request->getFoods()->contains($this)) {
            $request->getFoods()->push($this);
        }

    }

    /**
     * Remove request of this object
     * through the request_food cross reference table.
     *
     * @param ChildRequest $request
     * @return ChildFood The current object (for fluent API support)
     */
    public function removeRequest(ChildRequest $request)
    {
        if ($this->getRequests()->contains($request)) {
            $requestFood = new ChildRequestFood();
            $requestFood->setRequest($request);
            if ($request->isFoodsLoaded()) {
                //remove the back reference if available
                $request->getFoods()->removeObject($this);
            }

            $requestFood->setFood($this);
            $this->removeRequestFood(clone $requestFood);
            $requestFood->clear();

            $this->collRequests->remove($this->collRequests->search($request));

            if (null === $this->requestsScheduledForDeletion) {
                $this->requestsScheduledForDeletion = clone $this->collRequests;
                $this->requestsScheduledForDeletion->clear();
            }

            $this->requestsScheduledForDeletion->push($request);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->price = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collComboFoods) {
                foreach ($this->collComboFoods as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRequestFoods) {
                foreach ($this->collRequestFoods as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCombos) {
                foreach ($this->collCombos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRequests) {
                foreach ($this->collRequests as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collComboFoods = null;
        $this->collRequestFoods = null;
        $this->collCombos = null;
        $this->collRequests = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FoodTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
