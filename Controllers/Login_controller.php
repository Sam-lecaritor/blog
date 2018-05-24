<?php
namespace Controllers;

/**
 * Gestion du login administrateur
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */
use App\Validateur;

require 'config/mdp.php';

class Login_controller
{

    private $template;
    private $validateur;

    /**
     * constructeur
     *
     * @param object $twig gestionnaire de template
     * @return object Login_controller
     */

    public function __construct($twig)
    {
        $this->template = $twig;
        $this->validateur = new Validateur();

    }

    /**
     * redirection vers le formulaire de login admin
     *
     * @return void
     */

    public function redirAdminLogin()
    {
        echo $this->template->render('back/adminLogin.twig', array(
            'page_title' => 'login',
        ));
    }

    /**
     * Nettoie et verifie les données envoyés par le formulaire de login
     *
     * @return void redirection sur l'admin si succes ou redirection vers le formulaire si echec
     */
    public function logAdmin()
    {

        if (isset($_POST['user']) && isset($_POST['mdp'])) {

            $post['user'] = trim($_POST['user']);
            $post['mdp'] = trim($_POST['mdp']);
            $post['user'] = filter_var($post['user'], FILTER_SANITIZE_STRING);
            $post['mdp'] = filter_var($post['mdp'], FILTER_SANITIZE_STRING);

            if ($post['user'] === ADMIN_NAME
                && password_verify($post['mdp'], ADMIN_MDP)
                && $this->validateur->verifierCaptcha($post)) {

                $_SESSION['isADMIN'] = 'isadmin';

                header('location: ' . ROOT . '/admin');
                exit();

            } else {
                $this->redirAdminLogin();
            }

        } else {
            $this->redirAdminLogin();

        }
    }

}
