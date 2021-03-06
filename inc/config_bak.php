<?php

/**
 * 数据库配置文件
 */
$db     = array(
    'DB_TYPE' => 'mysqli',
    'DB_HOST' => '39.107.75.139',
    'DB_NAME' => 'school',
    'DB_USER' => 'root',
    'DB_PWD'  => 'root',
    'DB_PORT' => '3306',
);
$config = array(
    'debug'   => 1, //开启debug
    'log'     => 1, //开启日志记录
    'LOGFILE' => date('Ymd') . ".log", //日志存放的文件位置，默认当前项目目录下时间戳为单位
);
return array_merge($db, $config);
