<?php
include './MinPHP/run/init.php';
$act = $_GET['act'];
$act = empty($act) ? 'index' : $_GET['act'];
$menu = '';
switch($act){
    // 首页
    case 'index':
        $menu = ' - 欢迎';
        $file = './MinPHP/run/hello.php';
        break;
    default:
        $menu = ' - 欢迎';
        $file = './MinPHP/run/hello.php';
        break;
}
include './MinPHP/run/main.php';