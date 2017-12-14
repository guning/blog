<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 10:35
 */

include 'Common.class.php';
use core\DB;
use core\View;
use app\model\Article;
class Home extends Common
{
    private $model;
    public function __construct() {
        $this->model = new Article();
    }

    public function show() {
        $content = View::get('index');
        return $content;
    }

    public function api() {
        $list = $this->model->getUserList(1);
        foreach ($list as $k => $v) {
            $list[$k]['time'] = date("Y-m-d H:i:s", $list[$k]['time']);
        }
        $jsonList = json_encode($list);
        return $jsonList;
    }
}