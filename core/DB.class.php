<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/21
 * Time: 22:12
 */

namespace core;

class DB
{
    private static $_instance = null;
    protected static $_conn = null;

    public static function getInstance($dbConfig = [])
    {
        if (empty(self::$_instance)) {
            if (empty($dbConfig) || !is_array($dbConfig)) {
                $dbConfig = Config::getConfig('db_config');
            }
            self::$_instance = new DB($dbConfig);
        }
        return self::$_instance;
    }

    private function __construct($dbConfig)
    {
        if (!empty($dbConfig)) {
            $dsn = $dbConfig['type'] . ':host=' . $dbConfig['host'] . ';port=' .$dbConfig['port'] . ';dbname=' . $dbConfig['db_name'];
            $user = $dbConfig['user'];
            $pwd = $dbConfig['password'];
            try {
                self::$_conn = new \PDO($dsn, $user, $pwd);
            } catch (\PDOException $e) {
                Logger::DBErrorLog('Connection failed ' . json_encode($e->getMessage()));
                echo "500";
                exit;
            }
        } else {
            throw new \Exception('DB CONNECT ERROR:CONFIG IS NULL');
        }
    }

    private function formatArray($arr) {
        $res = [];
        foreach ($arr as $k => $v) {
            $res[':' . $k] = $v;
        }
        return $res;
    }

    public function exec($sql, $params) {
        $params = $this->formatArray($params);
        $pdoStatement = self::$_conn->prepare($sql);
        $res = $pdoStatement->execute($params);
        return $res !== false;
    }

    public function query($sql, $params) {
        $params = $this->formatArray($params);
        $res = self::$_conn->prepare($sql);
        $res->execute($params);
        if ($res !== false) {
            $res->setFetchMode(\PDO::FETCH_ASSOC);
            return $res->fetchAll();
        } else {
            throw new \Exception('GET DBDATA ERROR: ' . $sql);
        }
    }

    public function getDB() {
        return self::$_conn;
    }
}