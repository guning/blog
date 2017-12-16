<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/3
 * Time: 10:59
 */

namespace app\model;

use core\CommonHelper;
use core\Config;
use core\DB;
use core\MD;
class Article
{
    protected static $table = 'article';
    private $db = null;

    public function __construct($db_config = []) {
        if (empty($db_config)) {
            $db_config = Config::getConfig('db_config');
        }
        $this->db = DB::getInstance($db_config);
    }

    /**
     * getUserList:用户列表界面
     * @author by 罟宁
     * @param int $userId
     * @return array|\PDOStatement
     * createTime:
     */
    public function getUserList($userId) {
        $sql = "SELECT 
               a.id,a.title,a.summary,a.update_time as time,u.name 
               FROM article a
               LEFT JOIN 
               user u 
               ON a.user_id=u.id WHERE a.status=1";
        return $this->db->query($sql, ['user_id' => $userId]);
    }
    public function getAdminList() {
        $sql = "SELECT 
               a.id, a.title, u.name, a.create_time, a.update_time, a.status 
               FROM 
               user u 
               RIGHT JOIN 
               article a
               ON a.user_id=u.id";
        return $this->db->query($sql, []);
    }
    public function getArticle($articleId) {
        $sql = "SELECT title,summary,file FROM article WHERE id=:id LIMIT 1";
        $res = $this->db->query($sql, ['id' => $articleId]);
        $data = [];
        if (count($res) > 0) {
            $row = array_shift($res);
            $file = $row['file'];
            $row['file'] = MD::getContent($file);
            $data = $row;
        }
        return $data;
    }

    public function add($article, $content) {
        if (!is_array($article) || count($article) == 0) {
            return false;
        }
        if (!isset($article['file'])) {
            $article['file'] = CommonHelper::uniqidName();
        }
        $res = MD::setContent($article['file'], $content);
        if (!$res) {
            return false;
        }
        $article['create_time'] = $article['update_time'] = time();


        $sql = "INSERT INTO article (user_id,file,summary,title,update_time,create_time) VALUES (:user_id,:file,:summary,:title,:update_time,:create_time)";
        $res = $this->db->exec($sql, $article);
        return $res !== false;
    }

    public function updateArticle($articleId, $article, $content)
    {
        if (!is_numeric($articleId)) {
            return false;
        }
        $sql = "SELECT file FROM article WHERE id=:id LIMIT 1";
        $res = $this->db->query($sql, ['id' => $articleId]);
        if (!empty($res)) {
            $row = array_shift($res);
            $filename = $row['file'];
            $res = MD::setContent($filename, $content);
            if (!$res) {
                return false;
            }
            $article['update_time'] = time();
            $article['id'] = $articleId;
            $tmp = [];
            foreach ($article as $field => $value) {
                array_push($tmp, $field . '=' . ":$field");
            }
            $set = implode(',', $tmp);
            $sql = "UPDATE article SET $set WHERE id=:id";
            return $this->db->exec($sql, $article);
        } else {
            return false;
        }
    }

    public function delete($articleId) {
        if (!is_numeric($articleId)) {
            return false;
        }
        $sql = "DELETE FROM article WHERE id=:id LIMIT 1";
        return $this->db->exec($sql, ['id' => $articleId]);
    }

    public function changeStatus($articleId) {
        $sql = "UPDATE article SET status=status^1 WHERE id=:id";
        return $this->db->exec($sql, ['id' => $articleId]);
    }

}