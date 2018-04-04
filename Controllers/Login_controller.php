<?php
namespace Controllers;

require 'config/mdp.php';

class Login_controller{



    private $template;


    public function __construct($twig){

    $this->template = $twig;


    }



    public function logAdmin(){

    if(isset($_POST) 
    && $_POST['user'] === ADMIN_NAME 
    && password_verify($_POST['mdp'], ADMIN_MDP)){

            $_SESSION['isADMIN'] = 'isadmin';

            header('location: /blog/admin');
    }else{

            echo $this->template->render('back/adminLogin.twig', array(
            'page_title' => 'login'
            ));

        }

    }

}