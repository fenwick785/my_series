<?php
require_once('init.php');
$pdo = "";
$pdo = new PDO('mysql:host=localhost;dbname=my_series', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

function getIdSeries(){
        $requete ="SELECT id FROM series";
        $query = $pdo->prepare($requete);
        $response = $query->execute();
        $id_series = $response->fetch(PDO::FETCH_ASSOC);
 
        return $id_series;
}