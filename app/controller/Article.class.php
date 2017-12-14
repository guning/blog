<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 10:35
 */


include 'Common.class.php';
use app\model\Article as ArticleModel;
class Article extends Common
{
    private $model;
    public function __construct() {
        $this->model = new ArticleModel();
    }

    public function show() {
    }

    public function api() {
        $id = array_shift($this->args);
        $res = $this->model->getArticle($id);
        return json_encode($res);
    }
}