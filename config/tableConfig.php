<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/23
 * Time: 0:09
 */
return [
    [
        'table' => 'user_info',
        'field' => [],
        'primary_key' => 'id'
    ],
    [
        'table' => 'article',
        'field' => [
            ['user_id', 'summary', 'name'],
            ['int(10)', 'text', 'char(32)'],
            ['unsigned not null', 'COLLATE utf8_unicode_ci', 'COLLATE utf8_unicode_ci']
        ],
        'primary_key' => 'id'
    ]

];