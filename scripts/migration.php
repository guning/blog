<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/9
 * Time: 23:55
 */
include '../Loader.php';
try {
    foreach (\core\Config::getConfig('table_config') as $tableConfig) {
        echo $tableConfig['table'] . "\n";
        $table = \core\TableCreate::create()
            ->table($tableConfig['table'])
            ->fieldType($tableConfig['field'][0], $tableConfig['field'][1], $tableConfig['field'][2])
            ->primaryKey($tableConfig['primary_key'])
            ->run();
        echo $table;
        \core\DB::getInstance(\core\Config::getConfig('db_config'))->query($table);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
//create index id ON user (id);
//create index id ON article (id);
