<?php
require_once 'init.php';
require_once 'functions.php';

/***********************************************************************/
/*       Récupération du token nécessaires pour l'API Beta-series      */
/***********************************************************************/
if (isset($_POST['valider'])) {
    $url = "https://api.betaseries.com/members/auth?login=$login&password=$password";
    $curl = curl_init($url);
    curl_setopt_array($curl, array(
        CURLOPT_POSTFIELDS => "3.0",
        CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0', 'X-BetaSeries-Key: 2ca9f109bca9'),
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_RETURNTRANSFER => true,
    ));
    $response = curl_exec($curl);
    $code_infos = json_decode($response, true);
    $token = $code_infos['token'];
    file_put_contents($file_token, $token);
}
/****************************************************************************/
/*     Bouton de requête sur la page pour lancer l'obtention des données    */
/****************************************************************************/
?>

<form method='POST'>
<input type="text" name="valider" value='request' style="display:none;">
<button type='submit'>Envoyer la requête</button></form>
<?php if (isset($_POST['valider'])) {
    echo "<p><strong>Token : </strong>$token</p>";
    echo '<hr>';
    print_r("Token récupéré et ajouté au fichier 'token.txt avec succès");
}
;
?>