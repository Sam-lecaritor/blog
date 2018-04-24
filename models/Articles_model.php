<?php
namespace Models;

/**
 * Gestion de la base de données des articles
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/ 
 */
class Articles_model
{

    private $_db;
    private $_articleParPages = 6;

    /**
     * Constructeur
     * 
     * @param  null
     * @return void
     */
    public function __construct()
    {

        $db = new \App\Db_connect();
        $this->_db = $db->connect();

    }

        /**
         * Recupere la liste de tout les articles et renvoie la totalité des données
         *
         * @param  null
         * @return array(articles)
         */
    public function getListeArticles()
    {

        //eviter le select * pour eviter les bugs + bouffage de memoire

        $billets = $this->_db->query('select * from articles');

        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);
        } else {
            return null;
        }

    }

/**
 * recupere la liste des articles
 * selon un index et une limite en nombre
 * et renvoie la totalité des données
 *
 */

    public function getListeArticlesLimit($index)
    {

        $index = ($index - 1) * $this->_articleParPages;

        $billets = $this->_db->prepare(
            "SELECT * from articles
        ORDER BY id_chapitre
        LIMIT $index, $this->_articleParPages"
        );

        $billets->execute();

        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);
        } else {
            return null;
        }

    }

    public function getListePublishedArticlesLimit($index)
    {

        $index = ($index - 1) * $this->_articleParPages;

        $billets = $this->_db->prepare(
            "SELECT * from articles
            WHERE published = 1
            ORDER BY id_chapitre
            LIMIT $index, $this->_articleParPages"
        );

        $billets->execute();

        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);
        } else {
            return null;
        }

    }

/**
 * recupere un article grace au slug de l'url
 * renvoie la totalité des données de l'article
 */

    public function getArticleBySlug($slug)
    {

        $slug = filter_var($slug, FILTER_SANITIZE_URL);

        $billet = $this->_db->prepare('select * from articles WHERE slug=?');

        $billet->execute(array($slug));

        return $billet->fetch($this->_db::FETCH_ASSOC);

    }

/**
 * recupere un article grace a son id_chapitre
 * renvoie la totalité des données de l'article
 */

    public function getArticleById($idChapitre)
    {

        $billet = $this->_db->prepare('select * from articles WHERE id_chapitre=?');

        $billet->execute(array($idChapitre));

        return $billet->fetch($this->_db::FETCH_ASSOC);

    }

/**
 * enregistrement d'un nouvel article dans la base de donnée
 * renvoie false si une erreur a été detecté ou
 *  si l'article n'est pas enregistré
 *
 */
    public function setArticle($datas)
    {

        $billet = $this->_db->prepare(
            "INSERT INTO articles (title, text, slug, id_chapitre, published)
             VALUES (:title, :text, :slug, :id_chapitre, :published)"
        );

        $billet->bindParam(':title', $title);
        $billet->bindParam(':text', $text);
        $billet->bindParam(':slug', $slug);
        $billet->bindParam(':id_chapitre', $id_chapitre);
        $billet->bindParam(':published', $published);

        if (isset($datas['published'])) {
            $published = 1;
        } else {
            $published = 0;
        }

        $title = $datas['titre'];
        $text = $datas['texte'];
        $slug = preg_replace('`[^a-z0-9]+`', '-', $datas['slug']);
        $slug = trim($slug, '-');
        $id_chapitre = $datas['chapitre'];

        return $billet->execute();

    }

/**
 *
 * mise a jour d'un article
 *
 *
 */

    public function updateArticle($datas)
    {

        $idChapitre = intval($datas['chapitre']);

        $billet = $this->_db->prepare(
            "UPDATE articles
            SET title= :title, text= :text, slug= :slug , published= :published
            WHERE id_chapitre= $idChapitre
            LIMIT 1"
        );

        $billet->bindParam(':title', $title);
        $billet->bindParam(':text', $text);
        $billet->bindParam(':slug', $slug);
        $billet->bindParam(':published', $published);

        if (isset($datas['published'])) {
            $published = 1;
        } else {
            $published = 0;
        }

        $title = $datas['titre'];
        $text = $datas['texte'];
        $slug = preg_replace('`[^a-z0-9]+`', '-', $datas['slug']);
        $slug = trim($slug, '-');

        return $billet->execute();

    }

    public function DeletArticle($slug)
    {

        $billet = $this->_db->prepare(
            "DELETE FROM articles
            WHERE slug= :slug
            LIMIT 1");

        $billet->bindParam(':slug', $slug);

        return $billet->execute();
    }

    /**
     * Compter tout les articles
     */
    public function countArticles()
    {

        $test = $this->_db->query("SELECT COUNT(*) FROM articles");
        return $test->fetchColumn();

    }

/**
 * compter tout les articles publiés
 */
    public function countPublishedArticles()
    {

        $test = $this->_db->query(
            "SELECT COUNT(*) 
            FROM articles 
            WHERE published=true"
        );
        return $test->fetchColumn();

    }

    /**
     * compter le nombre de page d'articles publiés
     */

    public function countPagesPublishedArticles()
    {

        return ceil($this->countPublishedArticles() / $this->_articleParPages);

    }

    /**
     * compter le nombre de page d'articles publiés ou non
     */
    public function countPagesArticles()
    {

        return ceil($this->countArticles() / $this->_articleParPages);

    }

    public function getIndexDernierChapitre()
    {

        $billet = $this->_db->prepare(
            'SELECT id_chapitre
                 From articles
                 ORDER BY id_chapitre DESC
                 LIMIT 1'
        );

        $billet->execute();

        return $billet->fetch($this->_db::FETCH_ASSOC);

    }

}
