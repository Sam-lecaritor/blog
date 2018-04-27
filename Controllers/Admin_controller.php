<?php
namespace Controllers;

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

use App\Validateur;
use Models\Articles_model;
use Models\Commentaires_model;

class Admin_controller
{

    private $template;
    private $article_model;
    private $Comment_model;
    private $validateur;

/**
 * Constructeur
 *
 * @param  object (twig)
 * @return object(Admin_controller)
 */
    public function __construct($twig)
    {

        $this->template = $twig;
        $this->article_model = new Articles_model();
        $this->Comment_model = new Commentaires_model();
        $this->validateur = new Validateur();

    }

/**
 * lister les articles
 *
 * @param  int index de la page
 * @return mixed
 * rendu de la page liste des articles
 */

    public function getArticlesList($params)
    {
        //compter le nombre de pages d'articles
        $nbr_pages = $this->article_model->countPagesArticles();

        if (!isset($params[3]) || $params[3] < 1) {
            $articles = $this->article_model->getListeArticlesLimit(1);
            $params[3] = 1;

        } else {
            $articles = $this->article_model->getListeArticlesLimit(intval($params[3]));
        }

        foreach ($articles as $key => &$value) {

            $count = $this->Comment_model->countAllComments($value['id_chapitre']);
            $reported = $this->Comment_model->countReportedComments($value['id_chapitre']);
            $value['comments'] = $count[0];
            $value['reported'] = $reported[0];
        }

        echo $this->template->render('back/articles.twig', array(
            'articles' => $articles,
            'page_title' => 'liste des articles',
            'index_page' => intval($params[3]),
            'nbr_pages' => $nbr_pages,
        ));
    }

/**
 * Creation d'un nouvel article
 * @param null
 * @return null rendu de la page  editeur
 */
    public function getEditeur()
    {
        //recuperation de l'id_chapitre du dernier chapitre publié
        $count = $this->article_model->getIndexDernierChapitre();
        $count = intval($count['id_chapitre']) + 1;
        $this->getPageEditeur('poster article', null, null, $count);
    }

/**
 * Page d'accueil de l'administration
 * @param null
 * @return null rendu de la page dashboard
 */

    public function getAdmin()
    {
        $articles = $this->article_model->countArticles();
        $reported = $this->Comment_model->countAllReportedComments()[0];
        $commentaires = $this->Comment_model->countTotalComments();
        $max = $this->Comment_model->getMostComment()['id_chapitre'];

        echo $this->template->render('back/dashboard.twig', array(
            'page_title' => 'Administration',
            'nombre_articles' => $articles,
            'reported' => $reported,
            'comments' => $commentaires,
            'article_most_comment' => $max,

        ));
    }

/**
 * recupere un article grace au slug de l'url
 *
 * @param [array] id, date_creation, title, text, id_chapitre, slug, published
 * @return void renvoie sur le dashboard en cas de succes, ou un message d'erreur en cas d'echec, ou sur la page editeur si rien a été posté
 */

    public function postArticle()
    {
        if (isset($_POST)) {
            $validateur = $this->validateur->validerPostArticle($_POST);

            if ($validateur['checked'] === true) {
                $req = $this->article_model->setArticle($_POST);

                if (isset($req) && $req != false) {
                    //post reussi, enregistrement effectué
                    header('Location: /blog/admin');
                    exit();
                } else {
                    //post envoyé, enregistrement failed
                    $message[] = "erreur dans l' enregistrement dans la base de données";
                    $this->getPageEditeur('poster article', $_POST, $message, $_POST['id_chapitre']);
                }
            } else {
                //ici le rendu avec messages d'erreurs
                $this->getPageEditeur('poster article', $_POST, $validateur['messages'], $validateur['post']['id_chapitre']);
            }

        } else {
            //ici le rendu sans $_post
            $this->getPageEditeur('poster article', $_POST);
        }
    }

/**
 * edition d'un article
 *
 * @param [string] $slug
 * @return void
 */
    public function editArticle($slug)
    {
        $article = $this->article_model->getArticleBySlug($slug);
        $this->getPageEditeur('editer article', $article, null, $article['id_chapitre']);
    }

/**
 * mise a jour des articles
 *
 * @param [string] url
 * @return void renvoie sur la liste des articles en cas de succes, ou un message d'erreur en cas d'echec, ou sur la page editeur si rien a été posté
 */

    public function updateArticle($params)
    {

        if (isset($params[3]) && $params[3] === "post") {
            if (isset($_POST)) {
                $validateur = $this->validateur->validerUpdateArticle($_POST);
                if ($validateur['checked'] === true) {
                    $req = $this->article_model->updateArticle($_POST);
                    if (isset($req) && $req != false) {
                        header('Location: /blog/admin/articles/list/');
                        exit();

                    } else {
                        $this->getPageEditeur('update article', $_POST, null, $_POST['id_chapitre']);
                    }

                } else {
                    $this->getPageEditeur('update article', $_POST, $validateur['messages'], $_POST['id_chapitre']);
                }

            } else {
                $this->getPage404();
            }
        }
    }

/**
 * suppression d'un article
 *
 * @param [string] $slug
 * @return void redirection ou erreur
 */
    public function DeletArticle($slug)
    {
        $req = $this->article_model->DeletArticle($slug);

        if ($req) {
            header('Location: /blog/admin/articles/list');
            exit();
        } else {
            echo "erreur dans la suppression de l'article";
        }
    }

/**
 * Page recapitulative des commentaires publiés par les utilisateurs
 *
 * @return array comptage des commentaires
 */
    public function getCommentspage()
    {

        $comments['reported'] = $this->Comment_model->countAllReportedComments()[0];
        $comments['checked'] = $this->Comment_model->countAllcheckedComments()[0];

        $comments['news'] = $this->Comment_model->countAllNewComments()[0];

        echo $this->template->render('back/comments.twig', array(
            'page_title' => 'moderation commentaires',
            'comments' => $comments,
        ));
    }

/**
 * Page listant les commentaires publiés par les utilisateurs
 *
 * @param string url
 * @return array  commentaires
 */

    public function getCommentList($params)
    {
        if (!isset($params[3]) || $params[3] < 1) {
            $params[3] = 1;
        }

        if (isset($params['erreur'])) {
            $erreur = $params['erreur'];
        } else {
            $erreur = null;
        }

        if ($params[2] === 'reported') {
            $page = 'signalés';
            $nbr_pages = $this->Comment_model->countPagesReportedComments();

            $comments = $this->Comment_model->getReportedCommentsLimit(intval($params[3]));

        } elseif ($params[2] === 'news') {
            $page = 'non lus';
            $nbr_pages = $this->Comment_model->countPagesNewComments();
            $comments = $this->Comment_model->getNewCommentsLimit(intval($params[3]));

        } elseif ($params[2] === 'approuved') {
            $page = 'approuvés';
            $nbr_pages = $this->Comment_model->countPagescheckedComments();
            $comments = $this->Comment_model->getcheckedCommentsLimit(intval($params[3]));
        }

        echo $this->template->render('back/commentList.twig', array(
            'page_title' => 'moderation commentaires',
            'page' => $page,
            'comments' => $comments,
            'index_page' => intval($params[3]),
            'nbr_pages' => $nbr_pages,
            'link' => $params[2],
            'erreur' => $erreur,

        ));

    }

/**
 * Envoie de la page editeur
 *
 * @param [string] $page_title
 * @param [array] $article [array] id, date_creation, title, text, id_chapitre, slug, published {option}
 * @param [array] $messages string {option}
 * @param int $index_chapitre {option}
 * @return void
 */
    public function getPageEditeur($page_title, $article = null, $messages = null, $index_chapitre = null)
    {
        echo $this->template->render('back/editeurAricles.twig', array(
            'messages' => $messages,
            'page_title' => $page_title,
            'article' => $article,
            'index_chapitre' => $index_chapitre,
        ));
    }

    /**
     * Approuver un commentaire
     *
     * @param string url
     * @return void redirection vers la page d'origine ou erreur en cas d'echec
     *
     */

    public function checkComment($params)
    {
        $req = $this->Comment_model->checkComment($params[3]);

        if ($req) {
            $url = '/blog/admin/comments/' . $params[4] . '/' . $params[5];
            header('Location: ' . $url);
            exit();
        } else {
            $params[3] = $params[4];
            $params[4] = $params[5];
            $params['erreur'] = "impossible d'approuver ce commentaire";

            $this->getCommentList($params);
        }
    }

/**
 * supprimer un commentaire
 *
 * @param string url
 * @return void redirection vers la page d'origine ou erreur en cas d'echec
 *
 */
    public function deleteComment($params)
    {
        $req = $this->Comment_model->deleteComment($params[3]);

        if ($req) {
            $url = '/blog/admin/comments/' . $params[4] . '/' . $params[5];
            header('Location: ' . $url);
            exit();

        } else {
            $params[3] = $params[4];
            $params[4] = $params[5];
            $params['erreur'] = "impossible de supprimer ce commentaire";
            $this->getCommentList($params);
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
