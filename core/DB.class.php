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
                $dbConfig = Config::getConfig('test');
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
            $pwd = $dbConfig['pwd'];
            try {
                self::$_conn = new \PDO($dsn, $user, $pwd);
            } catch (\PDOException $e) {
                Logger::DBErrorLog('Connection failed ' . json_encode($e->getMessage()));
                exit;
            }
        } else {
            throw new \Exception('DB CONNECT ERROR:CONFIG IS NULL');
        }
    }

    public function query($sql) {
        $res = self::$_conn->query($sql);
        $data = array();
        if ($res !== false) {
            foreach ($res as $row) {
                foreach ($row as $key => $value) {
                    if (is_int($key)) {
                        unset($row[$key]);
                    }
                }
                $data[] = $row;
            }
            return $data;
        } else {
            throw new \Exception('GET DBDATA ERROR');
        }
    }
}