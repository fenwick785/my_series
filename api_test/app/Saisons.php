<?php
require_once 'init.php';
require_once 'functions.php';

$query = nume;

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
        $url = "https://api.betaseries.com/shows/seasons?id=$id_serie";
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
        
        file_put_contents($file_seasons, $data); /* 2 arguments, le fichier source et les données à inclure dans le fichier. Ici ce sont des variables déterminées dans init.php et dans chaque fichier 'obtXXXX'.php */
        echo "pour cette série : " . $data;

        /* AJOUT DES SAISONS DANS LA BASE DE DONNEES */

        $parsed_json = json_decode($data, true);
        $image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";
        
        foreach ($parsed_json['seasons'] as $seasons) {
            /* echo $seasons['number']; */
            $obt_seasons = $pdo->prepare("INSERT INTO season (id_serie_id, title, order_season, photo, total_episodes) VALUES (:id_serie_id, :title, :order_season, :photo, :total_episodes)");
            $obt_seasons->bindValue(':id_serie_id', $id_serie, PDO::PARAM_INT);
            $obt_seasons->bindValue(':order_season', $seasons['number'], PDO::PARAM_INT);
            $obt_seasons->bindValue(':title', "Saison ".$seasons['number'], PDO::PARAM_STR);
            $obt_seasons->bindValue(':total_episodes', $seasons['episodes'], PDO::PARAM_STR);
            if ($seasons['image'] !== null) {
                $obt_seasons->bindValue(':photo', $seasons['image'], PDO::PARAM_STR);
            } else {
                $obt_seasons->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
            }
            $obt_seasons->execute();
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