<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/23
 * Time: 0:09
 */
return [
    'table_config' => [
        [
            'table' => 'user',
            'field' => [
                ['name', 'pwd', 'permission'],
                ['varchar(20)', 'char(32)', 'int(1)'],
                ['COLLATE utf8_unicode_ci', 'COLLATE utf8_unicode_ci', 'unsigned not null']
            ],
            'primary_key' => 'id'
        ],
        [
            'table' => 'article',
            'field' => [
                ['title', 'summary', 'file', 'status', 'user_id'],
                [
                    'varchar(40)', 'varchar(150)',
                    'char(32)', 'int(1)', 'int(10)',
                ],
                [
                    'COLLATE utf8_unicode_ci', 'COLLATE utf8_unicode_ci',
                    'COLLATE utf8_unicode_ci', 'unsigned not null default 0', 'unsigned not null',
                ]
            ],
            'primary_key' => 'id'
        ]
    ]

];