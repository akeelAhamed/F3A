<?php

namespace App\Helpers;

use PDO;

class DB
{
    private static $host = DB_HOST;
    private static $db_name = DB_NAME;
    private static $username = DB_USER;
    private static $password = DB_PASSWORD;

    private static $statement;
    private static $params;
    private static $conn;

    /**
     * Model relations
     */
    private static $relation = [];

    /**
     * Relation class object
     */
    private static $relationObj = '';

    /**
     * Model table
     */
    private static $table;
 
    /**
     * Establish Database Connection
     *
     * @return mixed
     */
    public static function getConnection()
    {
        $conn = null;
 
        try {
            $conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
        } catch(\PDOException $e) {
            dd("Connection error: " . $e->getMessage());
        }
        
        self::$conn = $conn;
        return $conn;
    }

    /**
     * For relation
     */
    public static function setRelation(array $relation, $table)
    {
        if(count(self::$relation) != 0){
            foreach ($relation as $r => $c) {
                $relation = is_numeric($r)?$c:$r;
                $c = is_numeric($r)?'*':$c;
                self::$relation[$relation] = $c;
            }
        }else{
            self::$relation = $relation;
        }
        self::$table = \ucwords($table); // FOR NAMESPACE
    }
    
    /**
     * Set SQL query
     *
     * @param string $sql
     * @param mixed $data
     * @return self
     */
    public static function query($sql, $data = null)
    {
        // Get Connection
        $db = self::getConnection();

        // Prepare query statement
        $stmt = $db->prepare($sql);
    
        $params = array();

        if ($data) {
            // Sanitize
            foreach ($data as $key => $value) {
                $value = ($value)?$value:null;
                $params[$key] = htmlspecialchars(strip_tags($value));
            }
        }

        self::$statement = $stmt;
        self::$params = $params;

        return new static();
    }

    /**
     * Get row count
     *
     * @return mixed
     */
    public static function count()
    {
        // Execute query
        self::$statement->execute(self::$params);
        // Get count
        return self::$statement->rowCount();
    }

    /**
     * Run the SQL query
     *
     * @return mixed
     */
    public static function run()
    {
        try {
            return self::$statement->execute(self::$params);
        } catch (\PDOException $e) {
            dd('Server error:'.$e->getMessage());
        }
    }

    /**
     * Run the SQL query and 
     * get the first result
     *
     * @return object
     */
    public static function first()
    {
        // Execute query
        $result = self::get();
        
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }

    /**
     * Run the SQL query and 
     * get all the result
     *
     * @return array
     */
    public static function get()
    {
        // Execute query
        self::$statement->execute(self::$params);
        $total = self::$statement->rowCount();
    
        // Check if more than 0 record found
        $result = array();
        
        if ($total > 0) {
            while ($row = self::$statement->fetch(PDO::FETCH_ASSOC)) {
                array_push($result, (object) $row);
            }
        }

        if(count($result) != 0 && count(self::$relation) != 0){
            $result = Relation::init(self::$conn, self::$table, $result, self::$relation);
        }

        self::$relation = [];
        return $result;
    }

    /**
     * Get last inserted ID
     *
     * @return int
     */
    public static function insertedId()
    {
        // Get Connection
        $db = self::$conn;

        return (int) $db->lastInsertId();
    }
}