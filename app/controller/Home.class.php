<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 10:35
 */

use core\DB;
use core\View;
use app\model\Article;
class Home
{
    private function beforeRun() {

    }

    public function run($method, $args = []) {
        $this->beforeRun();
        $this->$method($args);
        $this->afterRun();
    }

    private function show() {
        $content = View::get('index');
        echo $content;
    }

    private function api($args = []) {
        $article = new Article();
        $list = $article->testList();
        $jsonList = json_encode($list);
        echo $jsonList;
    }

    private function afterRun() {

    }
}