<?php
/**
 * Controlleur back-office blog ecrivain
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */

namespace Controllers;

use App\Validateur;
use Models\Articles_model;

class Admin_controller
{

    private $template;
    private $article_model;
    private $validateur;

    public function __construct($twig)
    {

        $this->template = $twig;
        $this->article_model = new Articles_model();
        $this->validateur = new Validateur();

    }

    public function getArticlesList($params)
    {

        $nbr_pages = $this->article_model->countPagesArticles();

        if (!isset($params[3]) || $params[3] < 1) {

            $articles = $this->article_model->getListeArticlesLimit(1);
            $params[3] = 1;

        } else {

            $articles = $this->article_model->getListeArticlesLimit(intval($params[3]));

        }

        echo $this->template->render('back/articles.twig', array(
            'articles' => $articles,
            'page_title' => 'liste des articles',
            'index_page' => intval($params[3]),
            'nbr_pages' => $nbr_pages,
        ));

    }

    public function getEditeur()
    {

        $count = $this->article_model->getIndexDernierChapitre();
        $count = intval($count['id_chapitre']) + 1;

        echo $this->template->render('back/editeurAricles.twig', array(
            'page_title' => 'editeur',
            'index_chapitre' => $count,
        ));

    }

    public function getAdmin()
    {

        echo $this->template->render('back/dashboard.twig', array(
            'page_title' => 'Administration',
        ));
    }

    public function postArticle()
    {

        if (isset($_POST)) {

            $validateur = $this->validateur->validerPostArticle($_POST);

            if ($validateur['checked'] === true) {

                $req = $this->article_model->setArticle($_POST);

                header('Location: /blog/admin');
                exit();

                if ($req) {

                    echo $this->template->render('back/editeurAricles.twig', array(
                        'page_title' => 'poster article',
                        'article' => $validateur['post'],
                    ));

                } else {
                    echo $this->template->render('back/editeurAricles.twig', array(
                        'messages' => array(
                            'erreur' => "erreur dans l' enregistrement dans la base de données",
                        ),
                        'page_title' => 'poster article',
                        'article' => $_POST,
                    ));
                }

            } else {

                echo $this->template->render('back/editeurAricles.twig', array(
                    'messages' => $validateur['messages'],
                    'page_title' => 'poster article',
                    'article' => $_POST,
                ));

            }

        } else {

            echo $this->template->render('back/editeurAricles.twig', array(
                'page_title' => 'poster article',
                'article' => $_POST,
            ));

        }
    }

    public function editArticle($params)
    {

        $article = $this->article_model->getArticleBySlug($params[2]);
        echo $this->template->render('back/editSingleArticle.twig', array(
            'page_title' => 'editer article',
            'article' => $article,
        ));
    }

    /**
     * mise a jour des articles
     *
     *
     */

    public function updateArticle($params)
    {

        if (isset($params[3]) && $params[3] === "update") {
            if (isset($_POST)) {

                $validateur = $this->validateur->validerUpdateArticle($_POST);

                if ($validateur['checked'] === true) {
                    $req = $this->article_model->updateArticle($_POST);

                    header('Location: /blog/admin/articles/list/');
                    exit();

                    if ($req) {

                        echo $this->template->render('back/editSingleArticle.twig.twig', array(
                            'page_title' => 'update article',
                            'article' => $validateur['post'],
                        ));

                    } else {
                        echo $this->template->render('back/editSingleArticle.twig.twig', array(
                            'messages' => array(
                                'erreur' => "erreur dans l' enregistrement dans la base de données",
                            ),
                            'page_title' => 'update article',
                            'article' => $_POST,
                        ));
                    }

                } else {

                    echo $this->template->render('back/editSingleArticle.twig.twig', array(
                        'messages' => $validateur['messages'],
                        'page_title' => 'update article',
                        'article' => $_POST,
                    ));

                }

            } else {

                echo $this->template->render('back/editeurAricles.twig', array(
                    'page_title' => 'poster article',
                    'article' => $_POST,
                ));

            }

        }
    }

    public function DeletArticle($params = null)
    {
        //slug = $params[2]
        $req = $this->article_model->DeletArticle($params[2]);

        if ($req) {

            header('Location: /blog/admin/articles/list');
            exit();

        } else {

            echo "erreur dans la suppression de l'article";
        }

    }

/**
 * Envoie sur la page d'erreur 404
 * @param null
 * @return void
 */
    public function getPage404()
    {
        echo $this->template->render('page404.twig', array(
            'page_title' => '404',
        ));
    }

}
