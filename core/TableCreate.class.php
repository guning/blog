<?php

/**
 * todo:
 * User: guning
 * DateTime: 2017-11-22 10:26
 */
namespace core;
class TableCreate
{
    private static $_instance = null;
    private $table = '';
    private $fieldType = [
        //"id" => "int(10) unsigned not null auto_increment",
        "create_time" => "int(10) unsigned not null",
        "update_time" => "int(10) unsigned not null"
    ];
    private $primaryKey = 'id';
    private $engine = 'InnoDB';
    private $charset = 'utf8';
    private $collate = 'utf8_unicode_ci';

    public function run ()
    {
        $this->verify([$this->table, $this->fieldType, $this->primaryKey, $this->engine, $this->charset, $this->collate]);
        $sql = '';
        $sql .= "create table `{$this->table}` (";
        $sql .= "`{$this->primaryKey}` int(10) unsigned not null auto_increment,";
        foreach ($this->fieldType as $field => $conf) {
            $sql .= "`{$field}` {$conf},";
        }
        $sql .= "primary key (`{$this->primaryKey}`)";
        $sql .= ")engine={$this->engine} default charset={$this->charset} collate={$this->collate};";
        echo $sql;
    }

    public static function create()
    {
        self::$_instance = new TableCreate();
        return self::$_instance;
    }

    private function verify($vars) {
        if (empty(self::$_instance)) {
            throw new Exception('pls call the create function first');
            exit;
        }
        foreach ($vars as $var) {
            if (empty($var)) {
                throw new Exception('function can not be called at this time');
                exit;
            }
        }
    }

    private function __construct()
    {

    }

    public function table($table)
    {
        $this->verify([1]);
        $this->table = $table;
        return self::$_instance;
    }

    public function fieldType($names, $types, $exts)
    {
        $this->verify([1]);
        foreach ($names as $key => $name) {
            $type = $types[$key];
            $ext = $exts[$key];
            $this->fieldType = array_merge(["{$name}" => "{$type} {$ext}"], $this->fieldType);
        }
        return self::$_instance;
    }

    public function primaryKey ($field)
    {
        $this->verify([1]);
        $this->primaryKey = $field;
        return self::$_instance;
    }

    public function engine($engine)
    {
        $this->verify([1]);
        $this->engine = $engine;
        return self::$_instance;
    }

    public function charset($charset)
    {
        $this->verify([1]);
        $this->charset = $charset;
        return self::$_instance;
    }

    public function collate($collate)
    {
        $this->verify([1]);
        $this->collate = $collate;
        return self::$_instance;
    }
}