<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 10:35
 */


use core\View;
use app\model\Article as ArticleModel;
class Article
{
    private function beforeRun() {

    }

    public function run($method, $args = []) {
        $this->beforeRun();
        $this->$method($args);
        $this->afterRun();
    }

    private function show() {
    }

    private function api($args = []) {
        $id =1;
        $article = new ArticleModel();
        $content = $article->testArticle($id);
        echo $content;
    }

    private function afterRun() {

    }
}