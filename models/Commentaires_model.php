<?php
namespace Models;

/**
 * Gestion de la base de données des articles
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Models
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */

class Commentaires_model
{

    private $_db;

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
 * Enregistrement des article
 *
 * @param  array string(pseudo) string(texte)
 * @return bool
 */

    public function setComment(array $datas)
    {

        $billet = $this->_db->prepare(
            "INSERT INTO comments (pseudo, content, id_chapitre)
             VALUES (:pseudo, :content, :id_chapitre)"
        );

        $billet->bindParam(':pseudo', $pseudo);
        $billet->bindParam(':content', $content);
        $billet->bindParam(':id_chapitre', $chapitre);

        $pseudo = $datas['pseudo'];
        $content = $datas['comment'];
        $chapitre = $datas['id_chapitre'];

        return $billet->execute();

    }

    public function getCommentsById_chapitre($id)
    {

        $billets = $this->_db->prepare(
            "SELECT * from comments
            WHERE id_chapitre = :id
            ORDER BY id DESC"
        );

        $billets->bindParam(':id', $id);

        $billets->execute();

        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);
        } else {
            return null;
        }

    }

    public function signalerComment($id)
    {
        //$id = intval($id);
        d($id);
        $billet = $this->_db->prepare(
            "UPDATE comments
            SET signalement = 1
            WHERE id= :id
            LIMIT 1"
        );

        $billet->bindParam(':id', $id);
        return $billet->execute();

    }

    public function countAllComments($id)
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments
             WHERE id_chapitre= :id"
        );

        $billets->bindParam(':id', $id);

        $billets->execute();

        if ($billets) {
            return $billets->fetch();
        } else {
            return null;
        }

    }
}
