<?php
require_once 'init.php';
require_once 'functions.php';

$query = "SELECT * FROM serie";

$z = 0;

if (isset($_POST['valider'])) {
    $response = $pdo->query($query);
    echo 'TOUR : ' . $z . '<hr/>';
    $z++;


    while ($series = $response->fetch(PDO::FETCH_ASSOC)) {

        echo 'TOUR : ' . $z . '<hr/>';
        $z++;
        
        echo '<p><strong>Série ID :</strong> ' . $series['id'] . '</p><hr>';

        $id_serie = $series['id'];
        $url = "https://api.betaseries.com/shows/episodes?id=$id_serie";
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "3.0",
            CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0', 'X-BetaSeries-Key: 2ca9f109bca9'),
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $data = curl_exec($curl);
        
        file_put_contents($file_episodes, $data); /* 2 arguments, le fichier source et les données à inclure dans le fichier. Ici ce sont des variables déterminées dans init.php et dans chaque fichier 'obtXXXX'.php */
        echo "pour cette série : " . $data;

        /* AJOUT DES SAISONS DANS LA BASE DE DONNEES */

        $parsed_json = json_decode($data, true);
        
        foreach ($parsed_json['episodes'] as $episodes) {
            
            $obt_episodes = $pdo->prepare("INSERT INTO episode (id_season_id, title, synopsis, order_episode) VALUES (:id_season_id, :title, :synopsis, :order_episode)");
            $obt_episodes->bindValue(':id_season_id', $episodes['season'], PDO::PARAM_INT);
            $obt_episodes->bindValue(':order_episode', $episodes['episode'], PDO::PARAM_INT);
            $obt_episodes->bindValue(':title', $episodes['title'], PDO::PARAM_STR);
            $obt_episodes->bindValue(':synopsis', $episodes['description'], PDO::PARAM_STR);
            $obt_episodes->bindValue(':serie_id', $id_serie, PDO::PARAM_STR);
            if ($episodes['image'] !== null) {
                $obt_episodes->bindValue(':photo', $episodes['image'], PDO::PARAM_STR);
            } else {
                $obt_episodes->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
            }
            $obt_episodes->execute();
        }
        echo ("<p>Saison ajoutée avec succès</p>");
        
    }$curl->closeCursor();
    var_dump($data);
    
}

/* PENSE-BETE : PDO */
// pour chaque ligne (chaque enregistrement)
/* foreach ( $series as $serie )
{
echo $serie[0];
}; */

/****************************************************************************/
/*     Bouton de requête sur la page pour lancer l'obtention des données    */
/****************************************************************************/

?>

    <form method='POST'>
    <input type="text" name="valider" value='request' style="display:none;">
    <button type='submit'>Envoyer la requête</button></form>
    <?php if (isset($_POST['valider'])) {
    print_r("Saisons récupérées et ajoutées au fichier 'series.json'");
}
;
?>