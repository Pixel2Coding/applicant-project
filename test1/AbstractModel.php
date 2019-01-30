<?php

ini_set("display_errors", true);

define('DB_HOST', 'localhost');
define('DB_NAME', 'onstagin_test');
define('DB_USER', 'onstagin_all');
define('DB_PASS', 'All@123');
define('DB_CHAR', 'utf8');

abstract class AbstractModel
{

    protected static $instance = null;
    protected $_item = array();
    protected $_table;
    protected $_pk;

    public static function instance()
    {
        if (self::$instance === null) {
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            );
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array(array(self::instance(), $method), $args);
    }

    public static function run($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public function save()
    {
        $saveQuery = [];
        if (!isset($this->_item['id']) || $this->_item['id'] == '') {
            $query = "INSERT INTO " . $this->_table . " (`id`,`" . implode('`,`', array_keys($this->_item)) . "`) VALUES ('','" . implode('\',\'', $this->_item) . "')";
            self::run($query);
            self::load((int) self::instance()->lastInsertId());
        } else {
            foreach ($this->_item as $key => $value) {
                $saveQuery[] = "`" . $key . "` = '" . $value . "'";
            }
            $query = "UPDATE " . $this->_table . " SET " . implode(", ", $saveQuery) . " WHERE `" . $this->_pk . "` = '" . $this->_item['id'] . "'";
            self::run($query);
        }
        return $this;
    }

    public function load($id)
    {
        $query = "SELECT * FROM " . $this->_table . " WHERE  " . $this->_pk . " = " . $id;
        $this->_item = self::run($query)->fetch();
        return $this;
    }

    public function delete($id = false)
    {
        $query = "DELETE  FROM " . $this->_table . " WHERE  " . $this->_pk . " = " . $this->_item['id'];
        self::run($query);

        return $this;
    }

    public function getData($key = false)
    {
        if ($key) {
            return $this->_item[$key];
        }
        return (array) $this->_item;
    }

    public function setData($arr, $value = false)
    {
        if (is_array($arr)) {
            foreach ($arr as $arrKey => $arrValue) {
                $this->_item[$arrKey] = $arrValue;
            }
        } else {
            $this->_item[$arr] = $value;
        }
        return $this;
    }
}
