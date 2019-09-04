
<?php
require_once('init.php');
require_once('functions.php');
ini_set('display_errors','off');

/***********************************************************************/
/* Pré-traitement des données nécéssaires à l'ajout en base de données */
/***********************************************************************/
$public = "NA";
$parsed_json = json_decode($json_series, true);
$image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";
$x=0;$i=1;

    if (isset($_POST['valider'])) {
        foreach ($parsed_json['shows'] as $series) {
            $titre_serie = $pdo->prepare("INSERT INTO serie (id, title, nb_season, nb_episode, start_date, public, synopsis, photo, nationality, duration, status)VALUES(:id, :title, :nb_season, :nb_episode, :start_date, :public, :synopsis, :photo, :nationality, :duration, :status)");
            $titre_serie->bindValue(':id', $series['id'], PDO::PARAM_INT);
            $titre_serie->bindValue(':title', $series['title'], PDO::PARAM_STR);
            $titre_serie->bindValue(':nb_season', $series['seasons'], PDO::PARAM_INT);
            $titre_serie->bindValue(':nb_episode', $series['episodes'], PDO::PARAM_INT);
            $titre_serie->bindValue(':start_date', $series['creation'], PDO::PARAM_INT);
            $titre_serie->bindValue(':public', $public, PDO::PARAM_STR);
            $titre_serie->bindValue(':synopsis', $series['description'], PDO::PARAM_STR);
            $titre_serie->bindValue(':nationality', $series['language'], PDO::PARAM_STR);
            $titre_serie->bindValue(':duration', $series['length'], PDO::PARAM_INT);
            $titre_serie->bindValue(':status', $series['status'], PDO::PARAM_STR);
            if ($series['images']['poster'] !== NULL)
                { 
                    $titre_serie->bindValue(':photo', $series['images']['poster'], PDO::PARAM_STR);}  
            else 
                {
                    $titre_serie->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
                }
            $titre_serie->execute();
            $nbEntrees = ($x + $i);
         }
    }

/***********************************************************************/
/*     Bouton de requête sur la page pour lancer l'ajout des données   */
/***********************************************************************/
    ?>

<form method='POST'>
<input type="text" name="valider" value='request' style="display:none;">
<button type='submit'>Envoyer la requête</button></form>
<?php if (isset($_POST['valider'])) {
    echo '<hr>';
    print_r("$nbEntrées Séries ajoutées et/ou déjà présentes dans la base de données.");
}
;
?>

<?php


    /* Portion de code pour afficher et voir le contenu d'un fichier JSON du dossier 'data' */

    /* header('Content-type: application/json');
    $json = file_get_contents("./data/data_series.json");
    $objson = json_encode($json);
    /* print_r($objson);
    $decjson = json_decode($objson);
    var_dump($decjson); */

    ?>