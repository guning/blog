<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/18
 * Time: 0:31
 */
include 'Loader.php';
include "app/controller/Article.class.php";
$article = new Article();
$article->run('api', []);
//TableCreate::create()->table('test')->fieldType(['test'], ['int(10)'], ['not null'])->primaryKey('id')->run();
//var_dump($_SERVER['REQUEST_URI']);