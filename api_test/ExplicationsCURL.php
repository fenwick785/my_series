<?php

/* Voici donc CURL et son utilisation nous concernant et son fonctionnement avec une API vous est explique suffisament bien pour une première approche ICI --> https://www.youtube.com/watch?v=vq7yJDuf42E */

$curl = curl_init('https://api.thetvdb.com/login');
/* Ceci la première des 3 fonctions essentielles de l'utilisation de CURL. Elle sert à initialiser (bien joué sherlock) la connexion de l'API et la fonction CURL que nous allons paramétrer avec nos propres besoins , à savoir se connecter à l'API de TVDB */

/* Nous définissons maintenant une variable $userinfo qui renvoie nos identifiants et clés névcessaire à l'obtention d'un token (une clé encodée) et que j'ai obtenu en créant un compte sur TVDB et en générant dans les paramètress de compte. d'ou la présence de mon nom. On peut très bien créer un compte anynome pour l'utiliser avec le site comme reprendre tout simplement mes identifiants ci-dessous, c'est gratuit et ca fonctionne déjà ! */
$userinfo = array(
    'username' => 'benjamin.moares1hq',
    'userkey' => '80RTF823QE9YWLL0',
    'apikey' => '1S8A98QCCZLOZAI3',
);
/* Maintenant nous utilisons le méthode 'json_encode()' { https://www.php.net/manual/fr/function.json-encode.php } pour encoder notre array PHP en JSON pour l'envoyer à l'API. Pour cela comme nous allons voir, noous allons l'envoyer dans ce qui s'apelle le 'header http' { https://developer.mozilla.org/fr/docs/Web/HTTP/Headers }*/
$payload = json_encode($userinfo);

/* ensuite nous précisons le champs à envoyer en méthode POST (car c'est un envoi de données et non une réception dont nous avons besoin ici)  et donc ici le '$payload' qui n'est autre que notre array $userinfo encodé en JSON...*/
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

/* On envoie tout ca dans le 'header http' et on précise en paramètre le type de contenu de ce que nous envoyons */
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

/* Nous récupérons finalement nos donnée via le paramètre de CURL nommé 'CURLOPT_RETURNTRANSFER' */
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

/* On place tout ca dans une variable '$data' qui sera finanlement l'éxecution de la fonction que nous venons de paramétrer pour communiquer avec l'API de TVDB< Ceci est la seconde des trois fonctions importantes d'une fonction CURL */
$data = curl_exec($curl);

/* Maintenant, on conditionne tout ca... Pour que en cas d'erreur CURL, cela nous l'affiche, ou SINON que la fonction CURL s'éxecute correctement et nous renvoie donc ce fameux 'token' qui nous est demandé par cette API ppour chaque nouvelle requête en GET */
/* Donc SI nous n'avons pas de retour de données à la fin, verifions les erreurs et affichons les... */
if ($data === false) {
    var_dump(curl_error($curl));
    /* Ceci permets de renvoyer un texte d'erreur lié au typed 'erreur affiché. Il y en a bien évidemment plusieurs qui peuvent être retrouvé dans la documentation de curl (ici --> https://curl.haxx.se -- En anglais ! ) */
    /* LISTE DE PARAMETRES EN CAS DE PROBLEME SSL avec votre retour d'erreur SSL */
    /* curl_setopt($curl, CURLOPT_SSL_VERIFYEER, false); --- A NE PAS FAIRE car cela fait sauter l'utilisation en cas de problême SSL. Il vaut mieux trouver un certificat si il n'y en a pas.*/
    /* Il vaut mieux utiliser ceci :
curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . DIRECTORY_SEPARATOR . 'cert.cer', false)

Où 'cert.cer' est notre certificat exporté.
;
 */
} else { /* Et donc le SINON... dans lequel on demander finalement de transformer notre JSON recu en ARRAY d'objets. (Alex : on en a discuté au téléphone en ce qui concerne notamment l'exploitation des épisodes , le pointage de certaines données dans le but de pouvoir également gérer les saisons , créer leur propre table dans la base de données plus tard... etc) */
    $return = json_decode($data);
    /* var_dump($data); */
    /* echo "<hr>"; */
    /* On transforme notre string en ARRAY, en virant ce qui ne nous interesse pas... et diminuer le nombre d'indices */
    $delimiter = array(" ", ",", "'", "\"", "|", "\\", "/", ";", ":", "{", '}', "string", "(", ")");
    $replace = str_replace($delimiter, $delimiter[0], $data);
    $array = explode($delimiter[0], $replace);
    /* print_r($array); */
    /* On récupère le bon indice à l'index 5 de notre tableau */
    $token = $array[5];
    echo "<h1>Token :</h1>";
    print_r($token); /* FINALEMENT on affiche la '$data' qui contient donc notre ARRAY avec notre token dedans !! (VICTOIRE !) */

    /* Et on ferme la fonction que nous venons d'éxécuter. Troisième fonction CURL et la dernière des 3 que je citais au début. */
    echo "<hr><h1>Test d'importation des épisodes</h1><br>";
    $curl2 = curl_init('https://api.thetvdb.com/languages');
    $payload2 = json_encode($token);
    curl_setopt($curl2, CURLOPT_POSTFIELDS, $payload2);
    curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $data2 = curl_exec($curl2);
    curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, 'GET');
    $err = curl_error($curl2);
    $episodes = json_decode($data2);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $delimiter = array(" ", ",", "'", "\"", "|", "\\", "/", ";", ":", "{", '}', "string", "(", ")");
        $replace = str_replace($delimiter, $delimiter[0], $episodes);
        $array = explode($delimiter[0], $replace);
        print_r($array);
        /* On récupère le bon indice à l'index 5 de notre tableau */
        /* $episodes = $array[];
    echo $episodes; */
    }

    curl_close($curl2);
}

#!/bin/bash
