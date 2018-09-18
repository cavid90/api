<?php

/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 16.09.2018
 * Time: 21:30
 */
namespace Classes;
use \PDO;
class Db
{
    /**
     * Get the pdo database connection
     */

    private $_connection;
    private static $_instance; //The single instance
    private $_host = 'db';
    private $_username = 'root';
    private $_password = '';
    private $_database = 'apitest';
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct()
    {
        try {
            $this->_connection  = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->_connection->exec("set names utf8");
            /*** echo a message saying we have connected ***/
//            echo 'Connected to database';
        } catch (\PDOException $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Magic method clone is empty to prevent duplication of connection
     */

    private function __clone()
    {
    }

    /**
     * Get mysql pdo connection
     **/

    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @return PDO
     * Get instance connection $db
     */
    public static function getDb()
    {
        return self::getInstance()->getConnection();
    }

    /**
     * @param $sql
     * @return \PDOStatement
     * Raw query
     */
    public function raw($sql)
    {
        return $this->getConnection()->query($sql);
    }

    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`,`', array_keys($data));
        $fieldNames = '`'.$fieldNames.'`';

        $fieldValues = ':'.implode(', :', array_keys($data));

        $stmt = $this->getConnection()->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->getConnection()->lastInsertId();
    }
}