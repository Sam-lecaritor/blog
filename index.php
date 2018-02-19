<?php

require 'app/bootstrap.php';
$db= new Db_connect();
$db->connect();
$db->connect();

if(isset($_GET)){

    d($_GET['url']);
    $url=$_GET['url'];
}else{

    $url='home';
}

ob_start();
    switch ($url) {
        case 'home':
            echo "i égal 0";
            break;
        case 'home2':
            echo "i égal 1";
            break;
        case 'home3':
            echo "i égal 2";
            break;
            default:

    }

$content = ob_get_clean();


require "views/template/default.php";