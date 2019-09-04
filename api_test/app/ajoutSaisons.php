<?php
require_once 'init.php';
/*********************************************************************/
/*  Définition des requêtes, fetch et encodage/decodage des données  */
/* spécifiquement liées à l'id_serie et l'ajout des saisons à la BDD */
/*********************************************************************/

$query = "SELECT id FROM serie";
$response = $pdo->query($query);
$allId = $response->fetchAll(PDO::FETCH_ASSOC);
/* print_r($allId); */
$data = json_encode($allId, true);
$data_id = $response->fetch();
$id = $data_id;
echo $id;

/***********************************************************************/
/* Pré-traitement des données nécéssaires à l'ajout en base de données */
/***********************************************************************/



$parsed_json = json_decode($json_seasons, true);
$image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";

foreach ($parsed_json['seasons'] as $seasons) {
    $id_serie = $seasons['id'];
    echo $id_serie;
    $obt_seasons = $pdo->prepare("INSERT INTO season (id, id_serie_id, order_season, synopsis, photo, total_episodes)VALUES(:id, :id_serie_id, :title, :order_season, :synopsis, :photo, :total_episodes)");
    $obt_seasons->bindValue(':id', $id, PDO::PARAM_INT);
    $obt_seasons->bindValue(':id_serie_id', $id_serie, PDO::PARAM_INT);
    $obt_seasons->bindValue(':order_season', $seasons['number'], PDO::PARAM_INT);
    $obt_seasons->bindValue(':synopsis', $seasons['description'], PDO::PARAM_INT);
    $obt_seasons->bindValue(':total_episodes', $seasons['episodes'], PDO::PARAM_STR);
    if ($seasons['image'] !== null) {
        $obt_seasons->bindValue(':photo', $seasons['image'], PDO::PARAM_STR);
    } else {
        $obt_seasons->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
    }
    $obt_seasons->execute();
}
echo ("<p>Saison ajoutée avec succès</p>");
