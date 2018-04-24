<?php
namespace App;

class Validateur
{

    private $article_model;

    public function __construct()
    {

        $this->article_model = new \Models\Articles_model();
    }

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

    public function checkSlug($datas, $slug)
    {

        if ($slug === '') {
            $datas['messages']['slug'] = 'le slug  doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }

    public function checkSlugExist($datas, $slug)
    {

        if ($this->article_model->getArticleBySlug($slug)) {
            $datas['messages']['slug'] = 'slug deja utilisé';
            $datas['checked'] = false;
        }
        return $datas;
    }

//verification de la validité de l'entier pour le numero de chapitre
    public function checkChapitreIdValid($datas, $id)
    {

        if (!filter_var(intval($id), FILTER_VALIDATE_INT)) {
            $datas['messages']['chapitre'] = 'numéro de chapitre invalide';
            $datas['checked'] = false;
        }
        return $datas;
    }

//verifier si le numero de chapitre n'existe pas deja dans la base.
    public function checkChapitreIdExist($datas, $id)
    {

        if ($this->article_model->getArticleById($id)) {
            $datas['messages']['chapitre'] = 'numéro de chapitre deja utilisé';
            $datas['checked'] = false;
        }
        return $datas;
    }

// verification de la validité de la chaine du titre
    public function checkTitre($datas, $title)
    {

        if (!$title != '') {
            $datas['messages']['titre'] = 'le titre doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }

    public function checkTexte($datas, $text)
    {
        if (!$text != '') {
            $datas['messages']['texte'] = 'le texte doit etre renseigné';
            $datas['checked'] = false;
        }
        return $datas;
    }

    public function validerPostArticle($post)
    {

        $post['messages'] = [];
        $post['checked'] = true;

        $post['slug'] = $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkSlugExist($post, $post['slug']);
        $post = $this->checkChapitreIdExist($post, $post['chapitre']);
        $post = $this->checkChapitreIdValid($post, $post['chapitre']);
        $post = $this->checkTitre($post, $post['titre']);
        $post = $this->checkTexte($post, $post['texte']);

        return $validation = array(

            'checked' => $post['checked'],
            'messages' => $post['messages'],
            'post' => $post,

        );
    }

    public function validerUpdateArticle($post)
    {

        $datas['messages'] = [];
        $datas['checked'] = true;

        $post['slug'] = $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkChapitreIdValid($post, $post['chapitre']);
        $post = $this->checkTitre($post, $post['titre']);
        $post = $this->checkTexte($post, $post['texte']);

        return $validation = array(

            'checked' => $datas['checked'],
            'messages' => $datas['messages'],
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

        if (in_array($datas['id_chapitre'], $_SESSION['comments'])) {
            $datas['messages']['comment'] = "vous avez deja commenté ce billet.";
            $datas['checked'] = false;

        }

        return $datas;
    }

}
