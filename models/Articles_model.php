<?php
namespace Models;
require 'app/Db_connect.php';

class Articles_model{

private $db;

    public function __construct(){

        $db = new \App\Db_connect();
        $this->db = $db->connect();
        echo 'test pour le model des articles';

    }

    public function getListeArticles(){

 $billets = $this->db->query('select * from articles');
    return $billets->fetchall();

    }



}