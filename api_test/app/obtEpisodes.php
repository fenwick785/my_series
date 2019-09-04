<?php
require_once('init.php');
require_once('functions.php');
header('Content-type: application/json');

$public = "NA";
echo "<button type='submit' method='post'>Envoyer la requête</button>";

if ($_POST) {
    foreach ($parsed_json['shows'] as $series) {

        $titre_serie = $pdo->prepare("INSERT INTO serie (id, title, nb_season, nb_episode, start_date, public, synopsis, photo, nationality, duration, status)VALUES(:id, :title, :nb_season, :nb_episode, :start_date, :public, :synopsis, :photo, :nationality, :duration, :status)");
        $titre_serie->bindValue(':id', $series['id'], PDO::PARAM_INT);
        $titre_serie->bindValue(':title', $series['title'], PDO::PARAM_STR);
        $titre_serie->bindValue(':nb_season', $series['seasons'], PDO::PARAM_INT);
        $titre_serie->bindValue(':nb_episode', $series['episodes'], PDO::PARAM_INT);
        $titre_serie->bindValue(':start_date', $series['creation'], PDO::PARAM_INT);
        $titre_serie->bindValue(':public', $public, PDO::PARAM_STR);
        $titre_serie->bindValue(':synopsis', $series['description'], PDO::PARAM_STR);
        $titre_serie->bindValue(':photo', $series['images']['show'], PDO::PARAM_STR);
        $titre_serie->bindValue(':nationality', $series['language'], PDO::PARAM_STR);
        $titre_serie->bindValue(':duration', $series['length'], PDO::PARAM_INT);
        $titre_serie->bindValue(':status', $series['status'], PDO::PARAM_STR);
        $titre_serie->execute();
    }
    echo "Séries ajoutées avec succès";
}