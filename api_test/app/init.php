<?php

$pdo = "";
$request = "";
$id_series = [];

$login = "ResmoSyssla";
$password = "c53addd7db43d3dd943158b8715fb710";

/* $data_id = "./data/data_id.json"; */
$file_token = "../data/token.txt";
$file_series = "../data/data_series.json";
$file_seasons = "../data/data_seasons.json";
$file_episodes = "../data/data_episodes.json";

$json_token = file_get_contents("../data/token.txt");
$json_series = file_get_contents("../data/data_series.json");
$json_seasons = file_get_contents("../data/data_seasons.json");
$json_episodes = file_get_contents("../data/data_episodes.json");


$pdo = new PDO('mysql:host=localhost;dbname=my_series', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

?>