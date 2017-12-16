<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/9
 * Time: 0:10
 */

abstract class Common
{
    protected $args = [];
    protected function beforeRun($method) {
        $methods = get_class_methods($this);
        if (!in_array($method, $methods)) {
            \core\Logger::errorLog('Warning : access to a undefined method: ' . $_SERVER['REQUEST_URI']);
            echo "404";
            exit;
        }
    }

    public function run($method, $args = []) {
        try {
            $this->beforeRun($method);
            $this->args = $args;
            $res = $this->$method();
            $this->afterRun($res);
        } catch (Exception $e) {
            \core\Logger::errorLog($e->getMessage());
            $this->afterRun("something wrong!");
        }
    }

    protected function afterRun($content) {
        echo $content;
    }
}