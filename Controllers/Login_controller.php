<?php
namespace Controllers;

require 'config/mdp.php';

class Login_controller{



    private $template;


    public function __construct($twig){

    $this->template = $twig;


    }

    public function redirAdminLogin(){

            echo $this->template->render('back/adminLogin.twig', array(
            'page_title' => 'login'
            ));

    }


    public function logAdmin(){

    if(isset($_POST['user']) && isset($_POST['mdp']) ){

    $_POST['user'] = filter_var ( $_POST['user'], FILTER_SANITIZE_STRING);
    $_POST['mdp'] = filter_var ( $_POST['mdp'], FILTER_SANITIZE_STRING);

      if( $_POST['user'] === ADMIN_NAME && password_verify($_POST['mdp'], ADMIN_MDP)){

            $_SESSION['isADMIN'] = 'isadmin';

            header('location: /blog/admin');

        }else{
            $this->redirAdminLogin();
            }

    }else{
        $this->redirAdminLogin();

        }
    }

}