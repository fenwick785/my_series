<?php

namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */

    public function adminApi()
    {
        return $this->render("api/api.html.twig");
    }

    /**
     * @Route("/api/authorize", name="authorize")
     */

    public function authorize()
    {
        /***********************************************************************/
        /*       Récupération du token nécessaires pour l'API Beta-series      */
        /***********************************************************************/

        $login = "ResmoSyssla";
        $password = "c53addd7db43d3dd943158b8715fb710";
        $url = "https://api.betaseries.com/members/auth?login=$login&password=$password";
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_POSTFIELDS => "3.0",
            CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0', 'X-BetaSeries-Key: 2ca9f109bca9'),
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 9999,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => true,
        ));
        $response = curl_exec($curl);
        $code_infos = json_decode($response, true);
        $token = $code_infos['token'];
        return $token;

    }

    /**
     * @Route("/api/series", name="addseries")
     */
    public function ajoutSeriesApi()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=my_series', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $request = "";
        $id_series = [];
        $url = 'https://api.betaseries.com/shows/list?limit=500&recent=true&order=alphabetical&languages=fr,en,jp&fields=id,status,title,description,length,seasons,seasons_details,episodes,creation,genres,language,images';
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "3.0",
            CURLOPT_HTTPHEADER => array('Accept: application/json', 'X-BetaSeries-Version: 3.0', 'X-BetaSeries-Key: 2ca9f109bca9'),
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $data = curl_exec($curl);
        curl_close($curl);

        $public = "NA";
        $parsed_json = json_decode($data, true);
        $image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";
        $x = 0;
        $i = 1;

        foreach ($parsed_json['shows'] as $series) {
            $titre_serie = $pdo->prepare("INSERT INTO serie (id, title, nb_season, nb_episode, start_date, public, synopsis, photo, nationality, duration, status)VALUES(:id, :title, :nb_season, :nb_episode, :start_date, :public, :synopsis, :photo, :nationality, :duration, :status)");

            $id = (isset($series['id'])) ? $series['id'] : null;
            $title = (isset($series['title'])) ? $series['title'] : null;
            $description = (isset($series['description'])) ? $series['description'] : null;
            $status = (isset($series['status'])) ? $series['status'] : null;
            $nb_season = (isset($series['seasons'])) ? $series['seasons'] : null;
            $nb_episode = (isset($series['episodes'])) ? $series['episodes'] : null;
            $start_date = (isset($series['creation'])) ? $series['creation'] : null;
            $public = (isset($series['public'])) ? $series['public'] : null;
            $synopsis = (isset($series['synopsis'])) ? $series['synopsis'] : null;
            $nationality = (isset($series['language'])) ? $series['language'] : null;
            $duration = (isset($series['length'])) ? $series['length'] : null;

            $titre_serie->bindValue(':id', $id, PDO::PARAM_INT);
            $titre_serie->bindValue(':title', $title, PDO::PARAM_STR);
            $titre_serie->bindValue(':nb_season', $nb_season, PDO::PARAM_INT);
            $titre_serie->bindValue(':nb_episode', $nb_episode, PDO::PARAM_INT);
            $titre_serie->bindValue(':start_date', $start_date, PDO::PARAM_INT);
            $titre_serie->bindValue(':public', $public, PDO::PARAM_STR);
            $titre_serie->bindValue(':synopsis', $description, PDO::PARAM_STR);
            $titre_serie->bindValue(':nationality', $nationality, PDO::PARAM_STR);
            $titre_serie->bindValue(':duration', $duration, PDO::PARAM_INT);
            $titre_serie->bindValue(':status', $status, PDO::PARAM_STR);
            if ($series['images']['poster'] !== null) {
                $titre_serie->bindValue(':photo', $series['images']['poster'], PDO::PARAM_STR);} else {
                $titre_serie->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
            }
            $titre_serie->execute();
            $nbEntrees = ($i++);
        }

        $this->addFlash('success','Séries ajoutées dans la base de données depuis Beta-Series !');
        return $this->redirectToRoute('api');
    }

    /**
     * @Route("/api/saisons", name="addsaisons")
     */
    public function ajoutSaisonsApi()
    {
        /*************************************************************************/
        /*     Récupération des séries directement via une requête GET à l'API   */
        /*************************************************************************/

        $pdo = new PDO('mysql:host=localhost;dbname=my_series', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $response = $pdo->query("SELECT * FROM serie");
        $request = "";
        $id_series = [];

        while ($series = $response->fetch(PDO::FETCH_ASSOC)) {

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
            

            /* AJOUT DES SAISONS DANS LA BASE DE DONNEES */

            $parsed_json = json_decode($data, true);
            

            $image_NULL = "https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png";

            foreach ($parsed_json['seasons'] as $seasons) {

                $number = (isset($seasons['number'])) ? $seasons['number'] : null;
                $episodes = (isset($seasons['episodes'])) ? $seasons['episodes'] : null;
            
                $obt_seasons = $pdo->prepare("INSERT INTO season (id_serie_id, title, order_season, photo, total_episodes) VALUES (:id_serie_id, :title, :order_season, :photo, :total_episodes)");
                $obt_seasons->bindValue(':id_serie_id', $id_serie, PDO::PARAM_INT);
                $obt_seasons->bindValue(':order_season', $number, PDO::PARAM_INT);
                $obt_seasons->bindValue(':title', "Saison " . $number, PDO::PARAM_STR);
                $obt_seasons->bindValue(':total_episodes', $episodes, PDO::PARAM_STR);
                if ($seasons['image'] !== null) {
                    $obt_seasons->bindValue(':photo', $seasons['image'], PDO::PARAM_STR);
                } else {
                    $obt_seasons->bindValue(':photo', $image_NULL, PDO::PARAM_STR);
                }
                $obt_seasons->execute();
            }
            
        }
        curl_close($curl);
        $this->addFlash('success','Saisons ajoutées dans la base de données depuis Beta-Series !');
        return $this->redirectToRoute('api');
    }
}
