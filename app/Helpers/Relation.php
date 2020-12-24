<?php

namespace App\Helpers;

use PDO;

class Relation
{
    private static $statement;

    private static $params;

    private static $conn;

    private static $table;

    private static $rows;

    private static $relations=[];

    /**
     * Model namespace
     */
    private static $model = '\\App\\Models\\';

    /**
     * Define a has-many-through relationship.
     *
     * @param  string  $related
     * @param  string  $through
     * @param  string|null  $firstKey
     * @param  string|null  $secondKey
     * @param  string|null  $localKey
     * @param  string|null  $secondLocalKey
     * @param  string|array $column
     * @return HasManyThrough reltionship array
     */
    protected static function hasManyThrough($related, $through, $firstKey = 'id', $secondKey = 'id', $localKey = 'id', $secondLocalKey = 'id', $column='*'){

        $related = new $related();
        $through = new $through();
        $related = $related::$table_name;
        $through = $through::$table_name;

        $column = (is_array($column))? \implode(',', preg_filter('/^/', "$related.", $column)):$related.'.'.$column;

        foreach (self::$rows as $row) {
            $bind[] = $row->$localKey;
            $row->rkey = $localKey;
        }

        $query = "SELECT {$column}, {$through}.{$firstKey} AS rkey FROM {$related} INNER JOIN {$through} ON {$through}.{$secondLocalKey} = {$related}.{$secondKey} WHERE {$through}.{$firstKey} IN (:value)";

        return ['query'=>$query, 'bind'=> $bind, 'key'=>'rkey'];
    }

    /**
     * Define a one-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @param  string|array $column
     * @return HasMany reltionship array
     */
    protected static function hasMany($related, $foreignKey = null, $localKey = null, $column='*')
    {
        $related = new $related();
        $related = $related::$table_name;

        $column = (is_array($column))? \implode(',', (array) $column):$column;

        foreach (self::$rows as $row) {
            $bind[] = $row->$foreignKey;
            $row->rkey = $foreignKey;
        }

        $query = "SELECT {$column}, {$localKey} AS rkey FROM {$related} WHERE {$related}.{$localKey} IN (:value)";

        return ['query'=>$query, 'bind'=> $bind, 'key'=>'rkey'];
    }


    /**
     * Model relation
     * 
     * @param $row This table rows
     */
    public static function init($conn, $table, $row, $relations)
    {
        self::$conn = $conn;
        self::$rows = $row;
        self::$table = $table;
        if(count($relations) != 0){
            $rows = self::$rows;
            foreach($relations as $r => $c){
                $relation = is_numeric($r)?$c:$r;
                $column = is_numeric($r)?'*':$c;
                self::$relations[$relation] = self::getRelation($relation, $column, $row);
                foreach ($rows as $i => $row) {
                    $row->$relation = [];
                    $rkey = $row->rkey;
                    foreach (self::$relations[$relation] as $rel) {
                        if ($rel['rkey'] == $row->$rkey){
                            unset($rel['rkey']);
                            array_push($row->$relation, (object) $rel);
                        }
                        unset($row->rkey);
                    }
                }
            }
        }

        return self::$rows;
    }

    /**
     * Model relation
     * 
     * @param $relation Relation belongs to the table
     * @param $column   Columns to select
     * @param $row      This table rows
     * 
     */
    public static function getRelation($relation, $column)
    {
        $obj = self::$model.self::$table;
        $obj = new $obj();
        $relate = $obj->$relation();

        $relation = $relate['type'];
        unset($relate['type']);

        $args = array_values($relate);
        array_push($args, $column);

        return self::relate(...array_values(self::$relation(...$args)));
    }

    /**
     * Bind value to relation
     *
     * @param string $query
     * @param array  $bind
     * @param array  $key
     * @param array  $row
     * @return void
     */
    public static function relate($query, $bind, $key, $row=[])
    {
        $params = array_combine(
            array_map(
                // construct param name according to array index
                function ($v) {return ":p{$v}";},
                // get values of users
                array_keys($bind)
            ),
            $bind
        );

        $query = \str_replace(':value', implode(",", array_keys($params)), $query);

        return self::query($query, self::$conn, $params)->get($key);
    }

    /**
     * Set SQL query
     *
     * @param string $sql
     * @param mixed $data
     * @return self
     */
    public static function query($sql, $conn, $data = null)
    {
        // Get Connection
        self::$conn = $conn;
        $db = self::$conn;
    
        // Prepare query statement
        $stmt = $db->prepare($sql);

        $params = array();

        // Sanitize
        foreach ($data as $key => $value) {
            $params[$key] = htmlspecialchars(strip_tags($value));
        }

        self::$statement = $stmt;
        self::$params = $params;

        return new static();
    }

    /**
     * Run the SQL query and 
     * get all the result
     *
     * @return array
     */
    public static function get($rkey='id')
    {
        // Execute query
        self::$statement->execute(self::$params);
        $total = self::$statement->rowCount();
    
        // Check if more than 0 record found
        $result = array();
        
        if ($total > 0) {
            while ($row = self::$statement->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        }
        
        return $result;
    }
}