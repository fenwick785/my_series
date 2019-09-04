
<?php
require_once('init.php');
require_once('functions.php');

$query = "SELECT * FROM serie";
$response = $pdo->query($query);

/* Il manque quelque chose ou quelque chose que j'ai retiré qui fais que ca ne parcours pas tous les id... cela s'arret à un épisode */
if (isset($_POST['valider'])) {
    while ($series = $response->fetch(PDO::FETCH_ASSOC)) {
        echo '<p><strong>Série ID :</strong> '.$series['id'].'</p><hr>';

        $id_serie = $series['id'];
        $url = "https://api.betaseries.com/shows/seasons?id=$id_serie";
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => "3.0",
        CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0','X-BetaSeries-Key: 2ca9f109bca9'),
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $data = json_encode($response, true);
        file_put_contents($file_seasons, $data); /* 2 arguments, le fichier source et les données à inclure dans le fichier. Ici ce sont des variables déterminées dans init.php et dans chaque fichier 'obtXXXX'.php */
        echo "pour cette série : ".$data;        
        
    }
    $response->closeCursor();
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
        print_r("Saisons obtenues pour chaque série de la BDD et incluses au fichier 'data_seasons.json'");
    }
    ;
    ?>

    
<?php

/* $url = "https://api.betaseries.com/shows/seasons?id=$id_serie";
$curl = curl_init($url);
        curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => "3.0",
        CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0','X-BetaSeries-Key: 2ca9f109bca9'),
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $data = curl_exec($curl);
    $data_seasons = 'data_seasons.json';
    $data_seasons = fopen($data_seasons, 'w+');
    fwrite($data_seasons,$data);
    fclose($data_seasons);
    var_dump($data); */

 ?>