<?php

namespace App\Helpers;

use App\Helpers\DB;

/**
 * Base model class
 */
trait Model
{

    /**
     * Table name
     *
     * @var string
     */
    public static $table_name;

    /**
     * Query where
     * 
     * @var string
     */
    private static $sqlWhere = '';

    /**
     * Query relation
     * 
     * @var string
     */
    private static $sqlWith = '';

    /**
     * Skip rows
     * 
     * @var int
     */
    private static $skip = 0;

    /**
     * Limit rows
     * 
     * @var int
     */
    private static $limit;

    /**
     * Query Order by
     * 
     * @var string
     */
    private static $orderBy = '';

    /**
     * Query Group by
     * 
     * @var string
     */
    private static $groupBy = '';

    /**
     * Get single row
     *
     * @param any $val Column value
     * @param any $col COlumn name
     * 
     * @return mixed
     */
    public static function find($val, $col='id', $con='=')
    {
        $where = $col ." ". $con . " '" . $val . "'";
        self::$sqlWhere = (empty(self::$sqlWhere))?" WHERE ". $where:self::$sqlWhere.' AND '.$where ;
        $sql = "SELECT * FROM " . self::$table_name . self::$sqlWhere.' LIMIT 1';

        self::refresh();

        return DB::query($sql)->first();
    }

    /**
     * Get single row or die
     *
     * @param any $val Column value
     * @param any $col COlumn name
     * 
     * @return mixed
     */
    public static function findOrFail($val, $col='id')
    {
        $row = self::find($val, $col);
        if($row == null){
            print_r(\App\Helpers\View::render('errors.404'));
            exit();
        }
        self::refresh();
        return $row;
    }

    /**
     * Get all rows
     * 
     * @param any|array $col Column name(s)
     *
     * @return mixed
     */
    public static function get($col = '*')
    {
        $col = (is_array($col))?\implode(', ', $col):$col;
        
        $sql = "SELECT $col FROM " . self::$table_name . self::$sqlWhere . self::$groupBy . self::$orderBy . self::$limit;

        self::refresh();
        return DB::query($sql)->get();
    }
    
    /**
     * Get last row
     *
     * @return mixed
     */
    public static function last()
    {
        $sql = "SELECT * FROM " . self::$table_name . self::$sqlWhere." ORDER BY id DESC LIMIT 1";
        
        self::refresh();

        return DB::query($sql)->first();
    }

    /**
     * Get first row
     *
     * @return mixed
     */
    public static function first()
    {
        $sql = "SELECT * FROM " . self::$table_name . self::$sqlWhere." ORDER BY id LIMIT 1";
        
        self::refresh();

        return DB::query($sql)->first();
    }

    /**
     * Insert into table
     *
     * @param array $data
     * @return mixed
     */
    public static function create(array $data)
    {
        if(array_keys($data) !== range(0, count($data) - 1)):
            // Single Row converted for app
            $data = [$data];
        endif;

        //Will contain SQL snippets.
        $rowsSQL = array();
    
        //Will contain the values that we need to bind.
        $toBind = array();
        
        //Get a list of column names to use in the SQL statement.
        $columnNames = array_keys($data[0]);
    
        //Loop through our $data array.
        foreach($data as $arrayIndex => $row){
            $params = array();
            foreach($row as $columnName => $columnValue){
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue; 
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ", NOW(), NOW())";
        }
    
        //Construct our SQL statement
        $sql = "INSERT INTO " . self::$table_name . " (" . implode(", ", $columnNames) . ", created_at, updated_at) VALUES " . implode(", ", $rowsSQL);

        return self::run($sql, $toBind);
    }

    /**
     * Update table
     *
     * @param array $data
     * @return mixed
     */
    public static function update(array $data)
    {
        //Will contain Column names.
        $columnNames = array();
    
        //Will contain the values that we need to bind.
        $toBind = array();

        //Loop through our $data array.
        foreach($data as $columnName => $columnValue){
            $columnNames[] = $columnName. "=:" . $columnName;
            $param = ":" . $columnName;
            $toBind[$param] = $columnValue; 
        }
    
        //Construct our SQL statement
        $sql = "UPDATE " . self::$table_name . " SET " . implode(", ", $columnNames).self::$sqlWhere;
        
        return self::run($sql, $toBind);
    }

    /**
     * DELETE ROWS
     *
     * @return mixed
     */
    public static function delete()
    {
        $sql = "DELETE FROM " . self::$table_name . self::$sqlWhere;
        self::refresh();
        return DB::query($sql)->run();
    }

    /**
     * Get all rows count
     * 
     * @return mixed
     */
    public static function count()
    {
        $sql = "SELECT id FROM " . self::$table_name. self::$sqlWhere;
        $result = DB::query($sql)->count();
        self::refresh();
        return $result;
    }

    /**
     * Model relation
     */
    public static function with(array $relation)
    {
        DB::setRelation($relation, self::$table_name);
        return new static();
    }
    
    /**
     * Add where clause
     * 
     * @param any $val Column value
     * @param any $col COlumn name
     *
     * @return mixed
     */
    public static function where($val, $col='id', $con='=')
    {
        $where = $col.$con."'".$val."'";
        self::$sqlWhere .= (self::$sqlWhere == '')?' WHERE '.$where:' AND '.$where;
        return new static();
    }

    /**
     * Add whereIn clause
     * 
     * @param any $val Column value
     * @param any $col COlumn name
     *
     * @return mixed
     */
    public static function whereIn($val, $col='id')
    {
        $where = $col." IN (".$val.")";
        self::$sqlWhere .= (self::$sqlWhere == '')?' WHERE '.$where:' AND '.$where;
        return new static();
    }

    /**
     * Add or where clause
     * 
     * @param any $val Column value
     * @param any $col COlumn name
     *
     * @return mixed
     */
    public static function orWhere($val, $col='id', $con='=')
    {
        $where = $col.$con."'".$val."'";
        self::$sqlWhere .= (self::$sqlWhere == '')?' WHERE '.$where:' OR ('.$where.')';
        return new static();
    }

    /**
     * Add raw where clause
     * 
     * @param string $where Raw where
     *
     * @return mixed
     */
    public static function rawWhere($where)
    {
        self::$sqlWhere .= (self::$sqlWhere == '')?' WHERE '.$where:' AND '.$where;
        return new static();
    }

    /**
     * Add raw where or clause
     * 
     * @param string $where Raw where
     *
     * @return mixed
     */
    public static function rawWhereOr($where)
    {
        self::$sqlWhere .= (self::$sqlWhere == '')?' WHERE '.$where:' OR ('.$where.')';
        return new static();
    }

    /**
     * Add group by clause
     * 
     * @param any $val Column value
     * @param any $col COlumn name
     *
     * @return mixed
     */
    public static function groupBy($col='id')
    {
        self::$groupBy .= (self::$groupBy == '')?' ORDER BY '.$col:', '.$col;
        return new static();
    }

    /**
     * Add Order by clause
     * 
     * @param any $val Column value
     * @param any $col COlumn name
     *
     * @return mixed
     */
    public static function orderBy($col='id', $sort='ASC')
    {
        $order = $col.' '.$sort;
        self::$orderBy .= (self::$orderBy == '')?' ORDER BY '.$order:', '.$order;
        return new static();
    }
    
    /**
     * Add limit clause
     * 
     * @param int $rows No.of rows
     * @param int $skip Skip the rows
     *
     * @return mixed
     */
    public static function limit($rows=5, $skip=0)
    {
        self::$limit = ' LIMIT '.$skip.', '.$rows;
        return new static();
    }

    /**
     * Get last inserted row ID
     *
     * @return int
     */
    public static function insertedId()
    {
        return DB::insertedId();
    }

    /**
     * Refresh the variable
     *
     * @return int
     */
    public static function refresh()
    {
        self::$sqlWhere = '';
        self::$sqlWith = '';
        self::$orderBy = '';
        self::$limit = '';
    }

    /**
     * Finally run the query
     */
    private static function run($sql, $toBind)
    {
        self::refresh();
        return DB::query($sql, $toBind)->run();
    }

}