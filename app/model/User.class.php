<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/13
 * Time: 23:23
 */

namespace app\model;

use core\DB;
use core\Config;
class User
{
    protected static $table = 'user';
    private $db = null;

    public function __construct($db_config = []) {
        if (empty($db_config)) {
            $db_config = Config::getConfig('db_config');
        }
        $this->db = DB::getInstance($db_config);
    }

    public function getUsers() {
        $sql = "SELECT name,pwd FROM user";
        $res = $this->db->query($sql, []);
        $data = [];
        foreach ($res as $row) {
            $data[$row['name']] = $row['pwd'];
        }
        return $data;
    }

    public function getUserId($name) {
        $sql = "SELECT id FROM user WHERE name=:name LIMIT 1";
        $res = $this->db->query($sql, ['name' => $name]);
        $id = -1;
        if (count($res) > 0) {
            $row = array_shift($res);
            $id = $row['id'];
        }
        return $id;
    }

}