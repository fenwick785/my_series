<?php
require_once 'init.php';
require_once 'functions.php';

/*************************************************************************/
/*     Récupération des séries directement via une requête GET à l'API   */
/*************************************************************************/
if (isset($_POST['valider'])) {

    $url = 'https://api.betaseries.com/shows/list?limit=2000&recent=true&order=alphabetical&languages=fr,en,jp&fields=id,status,title,description,length,seasons,seasons_details,episodes,creation,genres,language,images';
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
    file_put_contents($file_series, $data);
}

/****************************************************************************/
/*     Bouton de requête sur la page pour lancer l'obtention des données    */
/****************************************************************************/
?>

<form method='POST'>
<input type="text" name="valider" value='request' style="display:none;">
<button type='submit'>Envoyer la requête</button></form>
<?php if (isset($_POST['valider'])) {
    echo '<br>';
    print_r("Séries récupérées et ajoutées au fichier 'data_series.json'");
    echo '<hr>';
    var_dump($data);
}
;
?>
<?php

?>