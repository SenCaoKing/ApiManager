<?php
defined('API') or exit('https://baidu.com');
return array(
    // 数据库连接配置
    'db' => array(
        'host'    => 'localhost', // 数据库地址
        'dbname'  => 'sen_api',   // 数据库名
        'user'    => 'root',      // 账号
        'passwd'  => 'root',       // 密码
        'linktype' => 'mysqli', // 数据库连接类型 支持mysqli与pdo两种类型
    ),
    // session配置
    'session' => array(
        'prefix' => 'api_'
    ),
    // cookie配置
    'cookie' => array(
        'navbar' => 'API_NAVBAR_STATUS',
    ),
    // 版本信息
    'version' => array(
        'no'   => 'v1.1', // 版本号
        'time' => '2018-06-08 20:00', // 版本时间
    )

);