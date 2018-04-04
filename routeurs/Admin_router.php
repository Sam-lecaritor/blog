<?php
namespace Routeurs;


class Admin_router{

    private $Admin_controller;




    public function __construct($twig){

        $this->Admin_controller= new \Controllers\Admin_controller($twig);

    }



    public function routerAdmin($params){


        if( isset($params[0]) && $params[0] ==='admin' && !isset($params[1]) ){

            $this->Admin_controller->getAdmin();

        }elseif(isset($params[1]) && $params[1] === 'articles' && isset($params[2])){
         

            switch ($params[2]) {

                case 'list':
                $this->Admin_controller->getArticlesList($params);

                break;

                case 'ajouter':
                $this->Admin_controller->getEditeur();

                break;

                case 'post':

                $this->Admin_controller->postArticle();

                break;

                default:
                $this->Admin_controller->getPage404();

            }

        }elseif(isset($params[1]) && $params[1] === 'article' && isset($params[2]) && isset($params[3])){

             switch ($params[3]) {

                case 'edit':
                $this->Admin_controller->editArticle($params);

                break;

                case 'update':
                $this->Admin_controller->updateArticle($params);

                break;

                case 'view':
                $this->Admin_controller->articlePreview($params);

                break;

                case 'delete':

                $this->Admin_controller->DeletArticle($params);

                break;

                default:
                $this->Admin_controller->getPage404();

            }



        }else{
            $this->Admin_controller->getPage404();
        }

    }




}