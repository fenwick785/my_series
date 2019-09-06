<?php
require_once 'init.php';

use App\Entity\Serie;
/*********************************************************************/
/*  Définition des requêtes, fetch et encodage/decodage des données  */
/* spécifiquement liées à l'id_serie et l'ajout des saisons à la BDD */
/*********************************************************************/

/***********************************************************************/
/* Pré-traitement des données nécéssaires à l'ajout en base de données */
/***********************************************************************/

$parsed_json = json_decode($json_seasons, true);
$image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";

$query = "SELECT * FROM serie";
$response = $pdo->query($query);
$id_serie =[];
while ($serie = $response->fetch(PDO::FETCH_ASSOC)) {
    $id_serie = $serie['id'];
    print_r($id_series);
}


$query2 = "SELECT * FROM season";
$response2 = $pdo->query($query2);


echo ("<p>Saison ajoutée avec succès</p>");
