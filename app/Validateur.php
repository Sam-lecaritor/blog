<?php
namespace App;

/**
 * Valide les entrée des formulaires utilisateurs
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */

use Models\Articles_model;

class Validateur
{

    private $article_model;

/**
 * constructeur
 * @param null
 * @return object Validateur
 */
    public function __construct()
    {
        $this->article_model = new Articles_model();
    }

/**
 * Nettoyage du slug
 *
 * @param [string] $slug
 * @return [array] $datas
 */
    public function formatSlug($slug)
    {
        if (!isset($slug)) {
            $slug = '';
        } else {
            $slug = preg_replace('`[^a-z0-9]+`', '-', $slug);
            $slug = trim($slug, '-');
        }
        return $slug;
    }

/**
 * Verification validité du slug
 *
 * @param [array] $datas
 * @param [string] $slug
 * @return [array] $datas
 */
    public function checkSlug($datas, $slug)
    {

        if (strlen($slug) < 1) {
            $datas['messages']['slug'] = 'le slug  doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }
/**
 * Verification de l'existence du slug dans la bdd
 *
 * @param [array] $datas
 * @param [string] $slug
 * @return [array] $datas
 */
    public function checkSlugExist($datas, $slug)
    {

        if ($this->article_model->getArticleBySlug($slug)) {
            $datas['messages']['slug'] = 'slug deja utilisé';
            $datas['checked'] = false;
        }
        return $datas;
    }

/**
 * verification de la validité de l'entier pour le numero de chapitre
 *
 * @param [array] $datas
 * @param [int] $id
 * @return [array] $datas
 */
    public function checkChapitreIdValid($datas, $id)
    {

        if (!filter_var(intval($id), FILTER_VALIDATE_INT)) {
            $datas['messages']['chapitre'] = 'numéro de chapitre invalide';
            $datas['checked'] = false;
        }
        return $datas;
    }

//

/**
 * verifier si le numero de chapitre n'existe pas deja dans la base.
 *
 * @param [array] $datas
 * @param [int] $id
 * @return [array] $datas
 */
    public function checkChapitreIdExist($datas, $id)
    {

        if ($this->article_model->getArticleById($id)) {
            $datas['messages']['chapitre'] = 'numéro de chapitre deja utilisé';
            $datas['checked'] = false;
        }
        return $datas;
    }

/**
 * verification de la validité de la chaine du titre
 *
 * @param [array] $datas
 * @param [string] $title
 * @return [array] $datas
 */
    public function checkTitre($datas, $title)
    {

        if (!$title != '') {
            $datas['messages']['titre'] = 'le titre doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }

/**
 * verification de la validité de la chaine du texte
 *
 * @param [array] $datas
 * @param [string] $title
 * @return [array] $datas
 */
    public function checkTexte($datas, $text)
    {
        if (!$text != '') {
            $datas['messages']['texte'] = 'le texte doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }

/**
 * verification de la validité d'un nouveau post
 *
 * @param [array] $post
 * @param [string] $title
 * @return [array] $datas
 */
    public function validerPostArticle($post)
    {
        $post['messages'] = [];
        $post['checked'] = true;
        $post['slug'] = $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkSlugExist($post, $post['slug']);
        $post = $this->checkChapitreIdExist($post, $post['id_chapitre']);
        $post = $this->checkChapitreIdValid($post, $post['id_chapitre']);
        $post = $this->checkTitre($post, $post['title']);
        $post = $this->checkTexte($post, $post['text']);

        return $validation = array(
            'checked' => $post['checked'],
            'messages' => $post['messages'],
            'post' => $post,
        );
    }

/**
 * verification de la validité d'une mise a jour de post
 *
 * @param [array] $post
 * @param [string] $title
 * @return [array] $datas
 */

    public function validerUpdateArticle($post)
    {

        $post['messages'] = [];
        $post['checked'] = true;

        $post['slug'] = $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkChapitreIdValid($post, $post['id_chapitre']);
        $post = $this->checkTitre($post, $post['title']);
        $post = $this->checkTexte($post, $post['text']);

        return $validation = array(

            'checked' => $post['checked'],
            'messages' => $post['messages'],
            'post' => $post,
        );

    }

    public function validerComment($post)
    {

        $datas = [];
        $datas['messages'] = [];
        $datas['checked'] = true;

        $datas['pseudo'] = trim($post['pseudo']);
        $datas['comment'] = trim($post['comment']);
        $datas['id_chapitre'] = trim($post['id_chapitre']);

        $datas['pseudo'] = filter_var($datas['pseudo'], FILTER_SANITIZE_STRING);
        $datas['comment'] = filter_var($datas['comment'], FILTER_SANITIZE_STRING);
        $strlen_pseudo = strlen($datas['pseudo']);
        $strlen_comment = strlen($datas['comment']);

        if ($strlen_pseudo < 3 || $strlen_pseudo > 30) {

            $datas['messages']['pseudo'] = "vous devez entrer un pseudo entre 3 et 30 caractères";
            $datas['checked'] = false;

        }

        if ($strlen_comment < 3 || $strlen_comment > 500) {
            $datas['messages']['comment'] = "vous devez entrer un texte entre 3 et 500 caractères";
            $datas['checked'] = false;

        }
        if (isset($_SESSION['comments'])) {
            if (in_array($datas['id_chapitre'], $_SESSION['comments'])) {
                $datas['messages']['comment'] = "vous avez deja commenté ce billet.";
                $datas['checked'] = false;

            }

        }

        return $datas;
    }

}
