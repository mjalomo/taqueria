<?php

namespace Base;

use \Combo as ChildCombo;
use \ComboQuery as ChildComboQuery;
use \ComboRequest as ChildComboRequest;
use \ComboRequestQuery as ChildComboRequestQuery;
use \Food as ChildFood;
use \FoodQuery as ChildFoodQuery;
use \Request as ChildRequest;
use \RequestFood as ChildRequestFood;
use \RequestFoodQuery as ChildRequestFoodQuery;
use \RequestQuery as ChildRequestQuery;
use \Exception;
use \PDO;
use Map\ComboRequestTableMap;
use Map\RequestFoodTableMap;
use Map\RequestTableMap;
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
 * Base class that represents a row from the 'request' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Request implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\RequestTableMap';


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
     * The value for the person_name field.
     *
     * @var        string
     */
    protected $person_name;

    /**
     * The value for the special_id field.
     *
     * @var        string
     */
    protected $special_id;

    /**
     * @var        ObjectCollection|ChildComboRequest[] Collection to store aggregation of ChildComboRequest objects.
     */
    protected $collComboRequests;
    protected $collComboRequestsPartial;

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
     * @var        ObjectCollection|ChildFood[] Cross Collection to store aggregation of ChildFood objects.
     */
    protected $collFoods;

    /**
     * @var bool
     */
    protected $collFoodsPartial;

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
     * @var ObjectCollection|ChildFood[]
     */
    protected $foodsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComboRequest[]
     */
    protected $comboRequestsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRequestFood[]
     */
    protected $requestFoodsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Request object.
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
     * Compares this with another <code>Request</code> instance.  If
     * <code>obj</code> is an instance of <code>Request</code>, delegates to
     * <code>equals(Request)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Request The current object, for fluid interface
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
     * Get the [person_name] column value.
     *
     * @return string
     */
    public function getPersonName()
    {
        return $this->person_name;
    }

    /**
     * Get the [special_id] column value.
     *
     * @return string
     */
    public function getSpecialId()
    {
        return $this->special_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Request The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RequestTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [person_name] column.
     *
     * @param string $v new value
     * @return $this|\Request The current object (for fluent API support)
     */
    public function setPersonName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->person_name !== $v) {
            $this->person_name = $v;
            $this->modifiedColumns[RequestTableMap::COL_PERSON_NAME] = true;
        }

        return $this;
    } // setPersonName()

    /**
     * Set the value of [special_id] column.
     *
     * @param string $v new value
     * @return $this|\Request The current object (for fluent API support)
     */
    public function setSpecialId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->special_id !== $v) {
            $this->special_id = $v;
            $this->modifiedColumns[RequestTableMap::COL_SPECIAL_ID] = true;
        }

        return $this;
    } // setSpecialId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RequestTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RequestTableMap::translateFieldName('PersonName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->person_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RequestTableMap::translateFieldName('SpecialId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->special_id = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = RequestTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Request'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(RequestTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRequestQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collComboRequests = null;

            $this->collRequestFoods = null;

            $this->collCombos = null;
            $this->collFoods = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Request::setDeleted()
     * @see Request::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RequestTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRequestQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RequestTableMap::DATABASE_NAME);
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
                RequestTableMap::addInstanceToPool($this);
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

                    \ComboRequestQuery::create()
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


            if ($this->foodsScheduledForDeletion !== null) {
                if (!$this->foodsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->foodsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RequestFoodQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->foodsScheduledForDeletion = null;
                }

            }

            if ($this->collFoods) {
                foreach ($this->collFoods as $food) {
                    if (!$food->isDeleted() && ($food->isNew() || $food->isModified())) {
                        $food->save($con);
                    }
                }
            }


            if ($this->comboRequestsScheduledForDeletion !== null) {
                if (!$this->comboRequestsScheduledForDeletion->isEmpty()) {
                    \ComboRequestQuery::create()
                        ->filterByPrimaryKeys($this->comboRequestsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->comboRequestsScheduledForDeletion = null;
                }
            }

            if ($this->collComboRequests !== null) {
                foreach ($this->collComboRequests as $referrerFK) {
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

        $this->modifiedColumns[RequestTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RequestTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RequestTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RequestTableMap::COL_PERSON_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'person_name';
        }
        if ($this->isColumnModified(RequestTableMap::COL_SPECIAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'special_id';
        }

        $sql = sprintf(
            'INSERT INTO request (%s) VALUES (%s)',
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
                    case 'person_name':
                        $stmt->bindValue($identifier, $this->person_name, PDO::PARAM_STR);
                        break;
                    case 'special_id':
                        $stmt->bindValue($identifier, $this->special_id, PDO::PARAM_STR);
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
        $pos = RequestTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPersonName();
                break;
            case 2:
                return $this->getSpecialId();
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

        if (isset($alreadyDumpedObjects['Request'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Request'][$this->hashCode()] = true;
        $keys = RequestTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPersonName(),
            $keys[2] => $this->getSpecialId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collComboRequests) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comboRequests';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'combo_requests';
                        break;
                    default:
                        $key = 'ComboRequests';
                }

                $result[$key] = $this->collComboRequests->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Request
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RequestTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Request
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPersonName($value);
                break;
            case 2:
                $this->setSpecialId($value);
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
        $keys = RequestTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPersonName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSpecialId($arr[$keys[2]]);
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
     * @return $this|\Request The current object, for fluid interface
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
        $criteria = new Criteria(RequestTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RequestTableMap::COL_ID)) {
            $criteria->add(RequestTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RequestTableMap::COL_PERSON_NAME)) {
            $criteria->add(RequestTableMap::COL_PERSON_NAME, $this->person_name);
        }
        if ($this->isColumnModified(RequestTableMap::COL_SPECIAL_ID)) {
            $criteria->add(RequestTableMap::COL_SPECIAL_ID, $this->special_id);
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
        $criteria = ChildRequestQuery::create();
        $criteria->add(RequestTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Request (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPersonName($this->getPersonName());
        $copyObj->setSpecialId($this->getSpecialId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getComboRequests() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComboRequest($relObj->copy($deepCopy));
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
     * @return \Request Clone of current object.
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
        if ('ComboRequest' == $relationName) {
            $this->initComboRequests();
            return;
        }
        if ('RequestFood' == $relationName) {
            $this->initRequestFoods();
            return;
        }
    }

    /**
     * Clears out the collComboRequests collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComboRequests()
     */
    public function clearComboRequests()
    {
        $this->collComboRequests = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collComboRequests collection loaded partially.
     */
    public function resetPartialComboRequests($v = true)
    {
        $this->collComboRequestsPartial = $v;
    }

    /**
     * Initializes the collComboRequests collection.
     *
     * By default this just sets the collComboRequests collection to an empty array (like clearcollComboRequests());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComboRequests($overrideExisting = true)
    {
        if (null !== $this->collComboRequests && !$overrideExisting) {
            return;
        }

        $collectionClassName = ComboRequestTableMap::getTableMap()->getCollectionClassName();

        $this->collComboRequests = new $collectionClassName;
        $this->collComboRequests->setModel('\ComboRequest');
    }

    /**
     * Gets an array of ChildComboRequest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRequest is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComboRequest[] List of ChildComboRequest objects
     * @throws PropelException
     */
    public function getComboRequests(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collComboRequestsPartial && !$this->isNew();
        if (null === $this->collComboRequests || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComboRequests) {
                // return empty collection
                $this->initComboRequests();
            } else {
                $collComboRequests = ChildComboRequestQuery::create(null, $criteria)
                    ->filterByRequest($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collComboRequestsPartial && count($collComboRequests)) {
                        $this->initComboRequests(false);

                        foreach ($collComboRequests as $obj) {
                            if (false == $this->collComboRequests->contains($obj)) {
                                $this->collComboRequests->append($obj);
                            }
                        }

                        $this->collComboRequestsPartial = true;
                    }

                    return $collComboRequests;
                }

                if ($partial && $this->collComboRequests) {
                    foreach ($this->collComboRequests as $obj) {
                        if ($obj->isNew()) {
                            $collComboRequests[] = $obj;
                        }
                    }
                }

                $this->collComboRequests = $collComboRequests;
                $this->collComboRequestsPartial = false;
            }
        }

        return $this->collComboRequests;
    }

    /**
     * Sets a collection of ChildComboRequest objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $comboRequests A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRequest The current object (for fluent API support)
     */
    public function setComboRequests(Collection $comboRequests, ConnectionInterface $con = null)
    {
        /** @var ChildComboRequest[] $comboRequestsToDelete */
        $comboRequestsToDelete = $this->getComboRequests(new Criteria(), $con)->diff($comboRequests);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->comboRequestsScheduledForDeletion = clone $comboRequestsToDelete;

        foreach ($comboRequestsToDelete as $comboRequestRemoved) {
            $comboRequestRemoved->setRequest(null);
        }

        $this->collComboRequests = null;
        foreach ($comboRequests as $comboRequest) {
            $this->addComboRequest($comboRequest);
        }

        $this->collComboRequests = $comboRequests;
        $this->collComboRequestsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ComboRequest objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ComboRequest objects.
     * @throws PropelException
     */
    public function countComboRequests(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collComboRequestsPartial && !$this->isNew();
        if (null === $this->collComboRequests || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComboRequests) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComboRequests());
            }

            $query = ChildComboRequestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRequest($this)
                ->count($con);
        }

        return count($this->collComboRequests);
    }

    /**
     * Method called to associate a ChildComboRequest object to this object
     * through the ChildComboRequest foreign key attribute.
     *
     * @param  ChildComboRequest $l ChildComboRequest
     * @return $this|\Request The current object (for fluent API support)
     */
    public function addComboRequest(ChildComboRequest $l)
    {
        if ($this->collComboRequests === null) {
            $this->initComboRequests();
            $this->collComboRequestsPartial = true;
        }

        if (!$this->collComboRequests->contains($l)) {
            $this->doAddComboRequest($l);

            if ($this->comboRequestsScheduledForDeletion and $this->comboRequestsScheduledForDeletion->contains($l)) {
                $this->comboRequestsScheduledForDeletion->remove($this->comboRequestsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComboRequest $comboRequest The ChildComboRequest object to add.
     */
    protected function doAddComboRequest(ChildComboRequest $comboRequest)
    {
        $this->collComboRequests[]= $comboRequest;
        $comboRequest->setRequest($this);
    }

    /**
     * @param  ChildComboRequest $comboRequest The ChildComboRequest object to remove.
     * @return $this|ChildRequest The current object (for fluent API support)
     */
    public function removeComboRequest(ChildComboRequest $comboRequest)
    {
        if ($this->getComboRequests()->contains($comboRequest)) {
            $pos = $this->collComboRequests->search($comboRequest);
            $this->collComboRequests->remove($pos);
            if (null === $this->comboRequestsScheduledForDeletion) {
                $this->comboRequestsScheduledForDeletion = clone $this->collComboRequests;
                $this->comboRequestsScheduledForDeletion->clear();
            }
            $this->comboRequestsScheduledForDeletion[]= clone $comboRequest;
            $comboRequest->setRequest(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Request is new, it will return
     * an empty collection; or if this Request has previously
     * been saved, it will retrieve related ComboRequests from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Request.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComboRequest[] List of ChildComboRequest objects
     */
    public function getComboRequestsJoinCombo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildComboRequestQuery::create(null, $criteria);
        $query->joinWith('Combo', $joinBehavior);

        return $this->getComboRequests($query, $con);
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
     * If this ChildRequest is new, it will return
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
                    ->filterByRequest($this)
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
     * @return $this|ChildRequest The current object (for fluent API support)
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
            $requestFoodRemoved->setRequest(null);
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
                ->filterByRequest($this)
                ->count($con);
        }

        return count($this->collRequestFoods);
    }

    /**
     * Method called to associate a ChildRequestFood object to this object
     * through the ChildRequestFood foreign key attribute.
     *
     * @param  ChildRequestFood $l ChildRequestFood
     * @return $this|\Request The current object (for fluent API support)
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
        $requestFood->setRequest($this);
    }

    /**
     * @param  ChildRequestFood $requestFood The ChildRequestFood object to remove.
     * @return $this|ChildRequest The current object (for fluent API support)
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
            $requestFood->setRequest(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Request is new, it will return
     * an empty collection; or if this Request has previously
     * been saved, it will retrieve related RequestFoods from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Request.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRequestFood[] List of ChildRequestFood objects
     */
    public function getRequestFoodsJoinFood(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRequestFoodQuery::create(null, $criteria);
        $query->joinWith('Food', $joinBehavior);

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
        $collectionClassName = ComboRequestTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the combo_request cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRequest is new, it will return
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
                    ->filterByRequest($this);
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
     * to the current object by way of the combo_request cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $combos A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRequest The current object (for fluent API support)
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
     * to the current object by way of the combo_request cross-reference table.
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
                    ->filterByRequest($this)
                    ->count($con);
            }
        } else {
            return count($this->collCombos);
        }
    }

    /**
     * Associate a ChildCombo to this object
     * through the combo_request cross reference table.
     *
     * @param ChildCombo $combo
     * @return ChildRequest The current object (for fluent API support)
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
        $comboRequest = new ChildComboRequest();

        $comboRequest->setCombo($combo);

        $comboRequest->setRequest($this);

        $this->addComboRequest($comboRequest);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$combo->isRequestsLoaded()) {
            $combo->initRequests();
            $combo->getRequests()->push($this);
        } elseif (!$combo->getRequests()->contains($this)) {
            $combo->getRequests()->push($this);
        }

    }

    /**
     * Remove combo of this object
     * through the combo_request cross reference table.
     *
     * @param ChildCombo $combo
     * @return ChildRequest The current object (for fluent API support)
     */
    public function removeCombo(ChildCombo $combo)
    {
        if ($this->getCombos()->contains($combo)) {
            $comboRequest = new ChildComboRequest();
            $comboRequest->setCombo($combo);
            if ($combo->isRequestsLoaded()) {
                //remove the back reference if available
                $combo->getRequests()->removeObject($this);
            }

            $comboRequest->setRequest($this);
            $this->removeComboRequest(clone $comboRequest);
            $comboRequest->clear();

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
     * Clears out the collFoods collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFoods()
     */
    public function clearFoods()
    {
        $this->collFoods = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collFoods crossRef collection.
     *
     * By default this just sets the collFoods collection to an empty collection (like clearFoods());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initFoods()
    {
        $collectionClassName = RequestFoodTableMap::getTableMap()->getCollectionClassName();

        $this->collFoods = new $collectionClassName;
        $this->collFoodsPartial = true;
        $this->collFoods->setModel('\Food');
    }

    /**
     * Checks if the collFoods collection is loaded.
     *
     * @return bool
     */
    public function isFoodsLoaded()
    {
        return null !== $this->collFoods;
    }

    /**
     * Gets a collection of ChildFood objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRequest is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildFood[] List of ChildFood objects
     */
    public function getFoods(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFoodsPartial && !$this->isNew();
        if (null === $this->collFoods || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collFoods) {
                    $this->initFoods();
                }
            } else {

                $query = ChildFoodQuery::create(null, $criteria)
                    ->filterByRequest($this);
                $collFoods = $query->find($con);
                if (null !== $criteria) {
                    return $collFoods;
                }

                if ($partial && $this->collFoods) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collFoods as $obj) {
                        if (!$collFoods->contains($obj)) {
                            $collFoods[] = $obj;
                        }
                    }
                }

                $this->collFoods = $collFoods;
                $this->collFoodsPartial = false;
            }
        }

        return $this->collFoods;
    }

    /**
     * Sets a collection of Food objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $foods A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRequest The current object (for fluent API support)
     */
    public function setFoods(Collection $foods, ConnectionInterface $con = null)
    {
        $this->clearFoods();
        $currentFoods = $this->getFoods();

        $foodsScheduledForDeletion = $currentFoods->diff($foods);

        foreach ($foodsScheduledForDeletion as $toDelete) {
            $this->removeFood($toDelete);
        }

        foreach ($foods as $food) {
            if (!$currentFoods->contains($food)) {
                $this->doAddFood($food);
            }
        }

        $this->collFoodsPartial = false;
        $this->collFoods = $foods;

        return $this;
    }

    /**
     * Gets the number of Food objects related by a many-to-many relationship
     * to the current object by way of the request_food cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Food objects
     */
    public function countFoods(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFoodsPartial && !$this->isNew();
        if (null === $this->collFoods || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFoods) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getFoods());
                }

                $query = ChildFoodQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRequest($this)
                    ->count($con);
            }
        } else {
            return count($this->collFoods);
        }
    }

    /**
     * Associate a ChildFood to this object
     * through the request_food cross reference table.
     *
     * @param ChildFood $food
     * @return ChildRequest The current object (for fluent API support)
     */
    public function addFood(ChildFood $food)
    {
        if ($this->collFoods === null) {
            $this->initFoods();
        }

        if (!$this->getFoods()->contains($food)) {
            // only add it if the **same** object is not already associated
            $this->collFoods->push($food);
            $this->doAddFood($food);
        }

        return $this;
    }

    /**
     *
     * @param ChildFood $food
     */
    protected function doAddFood(ChildFood $food)
    {
        $requestFood = new ChildRequestFood();

        $requestFood->setFood($food);

        $requestFood->setRequest($this);

        $this->addRequestFood($requestFood);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$food->isRequestsLoaded()) {
            $food->initRequests();
            $food->getRequests()->push($this);
        } elseif (!$food->getRequests()->contains($this)) {
            $food->getRequests()->push($this);
        }

    }

    /**
     * Remove food of this object
     * through the request_food cross reference table.
     *
     * @param ChildFood $food
     * @return ChildRequest The current object (for fluent API support)
     */
    public function removeFood(ChildFood $food)
    {
        if ($this->getFoods()->contains($food)) {
            $requestFood = new ChildRequestFood();
            $requestFood->setFood($food);
            if ($food->isRequestsLoaded()) {
                //remove the back reference if available
                $food->getRequests()->removeObject($this);
            }

            $requestFood->setRequest($this);
            $this->removeRequestFood(clone $requestFood);
            $requestFood->clear();

            $this->collFoods->remove($this->collFoods->search($food));

            if (null === $this->foodsScheduledForDeletion) {
                $this->foodsScheduledForDeletion = clone $this->collFoods;
                $this->foodsScheduledForDeletion->clear();
            }

            $this->foodsScheduledForDeletion->push($food);
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
        $this->person_name = null;
        $this->special_id = null;
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
            if ($this->collComboRequests) {
                foreach ($this->collComboRequests as $o) {
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
            if ($this->collFoods) {
                foreach ($this->collFoods as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collComboRequests = null;
        $this->collRequestFoods = null;
        $this->collCombos = null;
        $this->collFoods = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RequestTableMap::DEFAULT_STRING_FORMAT);
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
