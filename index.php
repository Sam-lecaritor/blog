<?php

require 'app/bootstrap.php';

$db= new App\Db_connect();
$db->connect();


if(isset($_GET['url'])){

    d($_GET['url']);
    $url=$_GET['url'];
}else{

    $url='home';
}

//ob_start();
    switch ($url) {
        case 'login':
            echo "i égal 0";
            //require du login controller
            break;
        case 'home2':
            echo "i égal 1";
            break;
        case 'home3':
            echo "i égal 2";
            break;
            default:
            echo "i égal default";

/*   echo $twig->render('index.twig', array(
        'moteur_name' => 'Twig'
    )); */

    }

//$content = ob_get_clean();

    echo $twig->render('index.twig', array(
        'moteur_name' => 'Twig'
    ));


//require "views/template/default.php";