<?php
namespace Routeurs;

use Controllers\Admin_controller;

class Admin_router
{

    private $Admin_controller;

    public function __construct($twig)
    {

        $this->Admin_controller = new Admin_controller($twig);

    }

    public function routerAdmin($params)
    {

        if (isset($params[0]) && $params[0] === 'admin' && !isset($params[1])) {

            $this->Admin_controller->getAdmin();

        } elseif (isset($params[1]) && $params[1] === 'comments') {

            if (!isset($params[2])) {
                $this->Admin_controller->getCommentspage();

            } else {
                switch ($params[2]) {

                    case 'approuved':
                        $this->Admin_controller->getCommentList($params);
                        break;

                    case 'news':
                        $this->Admin_controller->getCommentList($params);

                        break;
                    case 'reported':
                        $this->Admin_controller->getCommentList($params);

                        break;
                    case 'checked':
                        $this->Admin_controller->checkComment($params);
                        break;
                    case 'delete':

                        $this->Admin_controller->deleteComment($params);

                        break;

                    default:
                        $this->Admin_controller->getPage404();
                }
            }

        } elseif (isset($params[1]) && $params[1] === 'articles' && isset($params[2])) {

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

        } elseif (isset($params[1]) && $params[1] === 'article' && isset($params[2]) && isset($params[3])) {

            switch ($params[3]) {

                case 'edit':
                    $this->Admin_controller->editArticle($params[2]);

                    break;

                case 'post':
                    $this->Admin_controller->updateArticle($params);

                    break;

                case 'view':
                    $this->Admin_controller->articlePreview($params);

                    break;

                case 'delete':

                    $this->Admin_controller->DeletArticle($params[2]);

                    break;

                default:
                    $this->Admin_controller->getPage404();

            }

        } else {
            $this->Admin_controller->getPage404();
        }

    }

}
