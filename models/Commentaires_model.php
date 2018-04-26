<?php
namespace Models;

use App\Db_connect;

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
    private $_commentsParPages = 50;
    /**
     * Constructeur
     *
     * @param  null
     * @return void
     */
    public function __construct()
    {

        $db = new Db_connect();
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

    public function countTotalComments()
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments"
        );
        $billets->execute();

        if ($billets) {
            return $billets->fetchColumn();
        } else {
            return null;
        }

    }

    public function countReportedComments($id)
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments
             WHERE id_chapitre= :id and signalement = 1"
        );

        $billets->bindParam(':id', $id);
        $billets->execute();

        if ($billets) {
            return $billets->fetch();
        } else {
            return null;
        }

    }
    public function countAllReportedComments()
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments
             WHERE approuved = 0 and signalement = 1"
        );

        $billets->bindParam(':id', $id);
        $billets->execute();

        if ($billets) {
            return $billets->fetch();
        } else {
            return null;
        }

    }

    public function countAllNewComments()
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments
             WHERE approuved = 0 and signalement = 0"
        );

        $billets->bindParam(':id', $id);
        $billets->execute();

        if ($billets) {
            return $billets->fetch();
        } else {
            return null;
        }

    }

    public function countAllcheckedComments()
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(*)
             FROM comments
             WHERE approuved = 1"
        );

        $billets->bindParam(':id', $id);
        $billets->execute();

        if ($billets) {
            return $billets->fetch();
        } else {
            return null;
        }

    }

    public function getReportedCommentsLimit($index)
    {
        $index = ($index - 1) * $this->_commentsParPages;

        $billets = $this->_db->prepare(
            "SELECT id, pseudo, content, date_creation, id_chapitre
             FROM comments
             WHERE signalement = 1
             AND approuved = 0
             LIMIT $index, $this->_commentsParPages"
        );

        $billets->execute();
        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);

        } else {
            return null;
        }
    }

    public function getNewCommentsLimit($index)
    {
        $index = ($index - 1) * $this->_commentsParPages;

        $billets = $this->_db->prepare(
            "SELECT id, pseudo, content, date_creation, id_chapitre
             FROM comments
             WHERE signalement = 0
             AND approuved = 0
             LIMIT $index, $this->_commentsParPages"
        );

        $billets->execute();
        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);

        } else {
            return null;
        }
    }

    public function getcheckedCommentsLimit($index)
    {
        $index = ($index - 1) * $this->_commentsParPages;

        $billets = $this->_db->prepare(
            "SELECT id, pseudo, content, date_creation, id_chapitre
             FROM comments
             WHERE approuved = 1
             LIMIT $index, $this->_commentsParPages"
        );

        $billets->execute();
        if ($billets) {
            return $billets->fetchall($this->_db::FETCH_ASSOC);

        } else {
            return null;
        }
    }

    public function countPagesReportedComments()
    {

        return ceil(intval($this->countAllReportedComments()[0]) / $this->_commentsParPages);

    }

    public function countPagesNewComments()
    {

        return ceil(intval($this->countAllNewComments()[0]) / $this->_commentsParPages);

    }

    public function countPagescheckedComments()
    {

        return ceil(intval($this->countAllcheckedComments()[0]) / $this->_commentsParPages);

    }

    public function deleteComment($id)
    {

        $billet = $this->_db->prepare(
            "DELETE FROM comments
            WHERE id= :id
            LIMIT 1"
        );

        $billet->bindParam(':id', $id);
        return $billet->execute();

    }

    public function checkComment($id)
    {

        $billet = $this->_db->prepare(
            "UPDATE comments
            SET approuved = 1
            WHERE id= :id
            LIMIT 1"
        );

        $billet->bindParam(':id', $id);
        return $billet->execute();

    }

    public function signalerComment($id)
    {

        $billet = $this->_db->prepare(
            "UPDATE comments
            SET signalement = 1
            WHERE id= :id
            LIMIT 1"
        );

        $billet->bindParam(':id', $id);
        return $billet->execute();

    }

    public function getMostComment()
    {
        $billets = $this->_db->prepare(
            "SELECT COUNT(id), id_chapitre
            FROM comments
            GROUP BY id_chapitre
            HAVING COUNT(id) > 0
            ORDER BY COUNT(id) DESC;"

        );

        $billets->execute();
        if ($billets) {
            return $billets->fetch($this->_db::FETCH_ASSOC);

        } else {
            return null;
        }

    }

}
