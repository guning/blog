<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/3
 * Time: 10:59
 */

namespace app\model;


class Article
{
    protected static $table = 'article';

    public function testList() {
        $res = [];
        for ($i = 0; $i < 10; $i++){
            $tmp['id'] = rand(0, 1000);
            $tmp['title'] = 'javascript真几把难';
            $tmp['summary'] = '这是一篇吐槽文';
            $tmp['time'] = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d')-$i, date('Y')));
            array_push($res, $tmp);
        }
        return $res;
    }

    public function testArticle($id) {
        $conetnt = file_get_contents(APP_ROOT . 'mdFile' . SLASH . 'test.md');
        return $conetnt;
    }
}