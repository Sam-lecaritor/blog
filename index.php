<?php

require 'app/bootstrap.php';


if(isset($_GET['url'])){

    $urlarray = filter_var($_GET['url'], FILTER_SANITIZE_ENCODED);
    $urlarray = explode('/', $_GET['url']);

}else{

    $urlarray[0]='Home';
}


if($urlarray[0] === 'admin' ){
        if(isset($_SESSION['isADMIN'])
         && $_SESSION['isADMIN'] === 'isadmin' ){

            $routeur = new Routeurs\Admin_router($twig);
            $routeur->routerAdmin($urlarray);

        }else{

            //logincontroller do something
           $routeur = new Controllers\Login_controller($twig);
           $routeur->logAdmin();
        }

}else{

            $routeur = new Routeurs\Users_router($twig);
            $routeur->routerUser($urlarray);
}



