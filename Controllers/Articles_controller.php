<?php
namespace Controllers;

/**
 * Controlleur utilisteurs blog ecrivain
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

class Articles_controller
{

    private $template;
    private $article_model;
    private $Comment_model;
    private $validateur;

/**
 * Envoie sur la page listant les articles publiés
 *
 * @param object twig
 * @return object Articles_controller
 *
 */
    public function __construct($twig)
    {

        $this->template = $twig;
        $this->article_model = new Articles_model();
        $this->Comment_model = new Commentaires_model();
        $this->validateur = new Validateur();

    }
/**
 * Envoie sur la page listant les articles publiés
 *
 * @param string slug de l'article
 * @return array articles{ int: [id], datetime: [date_creation], string: [title], html-string: [text], string: [id_chapitre], string:[slug], bool, [published], comments{int: [count]}
 *
 */
    public function afficherListeArticles($url = null)
    {

        $nbr_pages = $this->article_model->countPagesPublishedArticles();

        if (!isset($url[1]) || $url[1] < 1) {

            $url[1] = 1;
            $listeArticles = $this->article_model->getListePublishedArticlesLimit(1);
            
        } elseif (isset($url[1])) {

            $listeArticles = $this->article_model->getListePublishedArticlesLimit($url[1]);
        }

        foreach ($listeArticles as $key => &$value) {

            $count = $this->Comment_model->countAllComments($value['id_chapitre']);
            $value['comments'] = $count[0];
        }

        echo $this->template->render('articles.twig', array(
            'page_title' => 'Chapitres',
            'articles' => $listeArticles,
            'index_page' => intval($url[1]),
            'nbr_pages' => $nbr_pages,
            'page_name' => 'articles',
        ));
    }

/**
 * Envoie sur la page single article
 *
 * @param string slug de l'article
 * @return array articles{ int: [id], datetime: [date_creation], string: [title], html-string: [text], string: [id_chapitre], string:[slug], bool, [published]}
 * (array) comments{int: [id], string: [pseudo], date-time: [date_creation], bool: [approuved], bool: [signalement], string: [id_chapitre]}
 * (array)messages{string}
 *
 */
    public function afficherArticle($slug)
    {
        $article = $this->article_model->getArticleBySlug($slug);
        if ($article
            && ($article['published'] === '1'
                || (isset($_SESSION['isADMIN']) && $_SESSION['isADMIN'] === 'isadmin'))) {

            $previous = $this->article_model->getPreviousArticle($article['id_chapitre']);

            $next = $this->article_model->getNextArticle($article['id_chapitre']);

            $comments = $this->Comment_model->getCommentsById_chapitre($article['id_chapitre']);
            $message = [];

            if (isset($_POST) && isset($_POST['signalement'])) {
                $this->Comment_model->signalerComment($_POST['signalement']);
                $comments = $this->Comment_model->getCommentsById_chapitre($article['id_chapitre']);
            }

            if (isset($_POST) && (isset($_POST['pseudo']) && isset($_POST['comment']) && isset($_POST['id_chapitre']))) {
                $comment['pseudo'] = $_POST['pseudo'];
                $comment['comment'] = $_POST['comment'];
                $comment['id_chapitre'] = $_POST['id_chapitre'];
                $comment = $this->validateur->validerComment($comment);

                if ($comment['checked'] === true) {

                    if ($this->Comment_model->setComment($comment) === true) {
                        $comments = $this->Comment_model->getCommentsById_chapitre($article['id_chapitre']);

                        $message[0] = "votre commentaire a été posté";
                        $_SESSION['comments'][] = $comment['id_chapitre'];

                    } else {
                        $message[0] = "une erreur est survenue pendant l'enregistrement du commentaire";
                    }

                } else {
                    $message = $comment['messages'];
                }
            }

            if ($article["published"] === "0"
                && (
                    !isset($_SESSION['isADMIN'])
                    || $_SESSION['isADMIN'] != 'isadmin')) {

                $this->getPage404();

            } else {
                echo $this->template->render('SingleArticles.twig', array(
                    'page_title' => $article["slug"],
                    'moteur_name' => 'Twig',
                    'article' => $article,
                    'previous' => $previous['slug'],
                    'next' => $next['slug'],
                    'message' => $message,
                    'comments' => $comments,
                    'nbr_comments' => count($comments),
                ));
            }
        } else {
            $this->getPage404();
        }
    }

/**
 * Envoie sur la page d'accueil
 * @param null
 * @return void
 */
    public function getPageIndex()
    {
        echo $this->template->render('index.twig',
            array(
                'page_title' => 'blog forteroche',
                'page_name' => 'home',
            ));
    }

/**
 * Envoie sur la page d'erreur 404
 * @param null
 * @return void
 */
    public function getPage404()
    {
        echo $this->template->render('page404.twig',
            array(
                'page_title' => '404 blog forteroche',
            ));
    }

}
