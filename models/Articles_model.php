<?php
namespace Models;


class Articles_model{

private $db;
private $articleParPages = 6;

    public function __construct(){

        $db = new \App\Db_connect();
        $this->db = $db->connect();

    }

/**
 * recupere la liste de tout les articles
 * et renvoie la totalité des données
 * 
 */
    public function getListeArticles(){

    $billets = $this->db->query('select * from articles');

    if($billets){
        return $billets->fetchall($this->db::FETCH_ASSOC);
    }else{
        return null;
    }

    }

/**
 * recupere la liste des articles 
 * selon un index et une limite en nombre
 * et renvoie la totalité des données
 * 
 */

    public function getListeArticlesLimit($index){

    $index = ($index - 1)*$this->articleParPages;

    $billets = $this->db->prepare(
        "SELECT * from articles 
        ORDER BY id_chapitre 
        LIMIT $index, $this->articleParPages");

    $billets->execute();

    if($billets){
        return $billets->fetchall($this->db::FETCH_ASSOC);
    }else{
        return null;
    }

    }

    public function getListePublishedArticlesLimit($index){

    $index = ($index - 1)*$this->articleParPages;

    $billets = $this->db->prepare(
        "SELECT * from articles
        WHERE published = 1
        ORDER BY id_chapitre
        LIMIT $index, $this->articleParPages");

    $billets->execute();

    if($billets){
        return $billets->fetchall($this->db::FETCH_ASSOC);
    }else{
        return null;
    }

    }

/**
 * recupere un article grace au slug de l'url
 * renvoie la totalité des données de l'article
 */

   public function getArticleBySlug($slug){

        $slug= filter_var($slug, FILTER_SANITIZE_URL);

        $billet = $this->db->prepare('select * from articles WHERE slug=?');

        $billet->execute(array($slug));
    
        return $billet->fetch($this->db::FETCH_ASSOC);

    }


/**
 * recupere un article grace a son id_chapitre
 * renvoie la totalité des données de l'article
 */

   public function getArticleById($idChapitre){

        $billet = $this->db->prepare('select * from articles WHERE id_chapitre=?');

        $billet->execute(array($idChapitre));
    
        return $billet->fetch($this->db::FETCH_ASSOC);

    }

/**
 * enregistrement d'un nouvel article dans la base de donnée
 * renvoie false si une erreur a été detecté ou
 *  si l'article n'est pas enregistré
 * 
 */
   public function setArticle($datas){


        $billet = $this->db->prepare("INSERT INTO articles (title, text, slug, id_chapitre, published) VALUES (:title, :text, :slug, :id_chapitre, :published)");

        $billet->bindParam(':title', $title);
        $billet->bindParam(':text', $text);
        $billet->bindParam(':slug', $slug);
        $billet->bindParam(':id_chapitre', $id_chapitre);
        $billet->bindParam(':published', $published);

        if(isset($datas['published'])){
            $published = 1;
        }else{
            $published = 0;
        }

        $title= $datas['titre'];
        $text= $datas['texte'];
        $slug= preg_replace('`[^a-z0-9]+`', '-', $datas['slug'] );
        $slug=trim($slug, '-');
        $id_chapitre= $datas['chapitre'];


    return $billet->execute();
 
    }

/**
 * 
 * mise a jour d'un article
 * 
 * 
 */

    public function updateArticle($datas){

        $idChapitre = intval($datas['chapitre']);

        $billet = $this->db->prepare("UPDATE articles 
            SET title= :title, text= :text, slug= :slug , published= :published
            WHERE id_chapitre= $idChapitre");

        $billet->bindParam(':title', $title);
        $billet->bindParam(':text', $text);
        $billet->bindParam(':slug', $slug);
        $billet->bindParam(':published', $published);

        if(isset($datas['published'])){
            $published = 1;
        }else{
            $published = 0;
        }

        $title= $datas['titre'];
        $text= $datas['texte'];
        $slug= preg_replace('`[^a-z0-9]+`', '-', $datas['slug'] );
        $slug=trim($slug, '-');

    return $billet->execute();

    }




    public function DeletArticle($slug){

        $billet = $this->db->prepare(
            "DELETE FROM articles 
            WHERE slug= :slug
            LIMIT 1");

        $billet->bindParam(':slug', $slug);

        return $billet->execute();
    }



/**
 * compter tout les articles
 */
    public function countArticles(){

    $test= $this->db->query("SELECT COUNT(*) FROM articles");
    return $test->fetchColumn();

    }

/**
 * compter tout les articles publiés
 */
    public function countPublishedArticles(){

    $test= $this->db->query("SELECT COUNT(*) FROM articles WHERE published=true");
    return $test->fetchColumn();

    }

    /**
     * compter le nombre de page d'articles publiés
     */

    public function countPagesPublishedArticles(){

        return ceil($this->countPublishedArticles()/$this->articleParPages);

    }

    /**
     * compter le nombre de page d'articles publiés ou non
     */
    public function countPagesArticles(){

        return ceil($this->countArticles()/$this->articleParPages);

    }


    public function getIndexDernierChapitre(){

        $billet = $this->db->prepare('SELECT id_chapitre
                 From articles 
                 ORDER BY id_chapitre DESC
                 LIMIT 1');

        $billet->execute();
    
        return $billet->fetch($this->db::FETCH_ASSOC);

    }





}