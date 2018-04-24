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
        


    $post['user'] = trim($_POST['user']);
    $post['mdp'] = trim($_POST['mdp']);
    $post['user'] = filter_var ( $post['user'], FILTER_SANITIZE_STRING);
    $post['mdp'] = filter_var ( $post['mdp'], FILTER_SANITIZE_STRING);

      if( $post['user'] === ADMIN_NAME && password_verify($post['mdp'], ADMIN_MDP)){

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