<?php
namespace App;

/**
 * Connexion a la base de donnée mysql
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Null
 * @author   Charroux Sam <charrouxsam@gmail.com>
 * @license  MIT https: //choosealicense.com/licenses/mit/
 */

use PDO;

require_once 'config/bdd.php';

class Db_connect
{

    private $host;
    private $db_name;
    private $db_user;
    private $db_pass;
    private $pdo;

    /**
     * constructeur
     *
     * @param null
     * @return obejct Db_connect
     */
    public function __construct()
    {
        $this->host = HOST;
        $this->db_name = DB_NAME;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;

    }

    /**
     * Connexion a la bdd
     *
     * @return pdo
     */
    public function connect()
    {

        if ($this->pdo === null) {
            try
            {
                $this->pdo = $dbh = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->db_user, $this->db_pass);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        return $this->pdo;
    }

}
