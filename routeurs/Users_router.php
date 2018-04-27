<?php
namespace Routeurs;

/**
 * Gestion des routes utilisateurs
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */

class Users_router
{

    private $Articles_controller;

    public function __construct($twig)
    {

        $this->Articles_controller = new \Controllers\Articles_controller($twig);

    }

    public function routerUser($params)
    {

        switch ($params[0]) {

            /**page d'accueil du site */
            case 'Home':

                $this->Articles_controller->getPageIndex();
                break;
            /**page de la liste des articles coté utilisateurs */
            case 'chapitres':

                $this->Articles_controller->afficherListeArticles('Chapitres', $params);
                break;
            /** page single article */
            case 'chapitre':

                $this->Articles_controller->afficherArticle($params[1]);
                break;

            default:
                $this->Articles_controller->getPage404();

        }

    }

}
