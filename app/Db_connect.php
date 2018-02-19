<?php

 require_once 'config/bdd.php'; 

class Db_connect{

    private $host;
    private $db_name;
    private $db_user;
    private $db_pass;
    private $pdo;



public function __construct(){

    $this->host = HOST;
    $this->db_name= DB_NAME;
    $this->db_user= DB_USER;
    $this->db_pass= DB_PASS;



}

public function connect(){

    if($this->pdo === null){
        try
        {
            $this->pdo=$dbh = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->db_user, $this->db_pass);
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

    echo 'conneccttttttttttttttttt';
    }
    return $this->pdo;
}

  /*   $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass); */

}