<?php

include_once('function.php');
// Désactivation du cache WSDL
ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient("function.wsdl");

try {
    if(isset($_GET['action']) && $_GET['action'] == 'loadMatches'){
        $matches = $client->getMatches();
        echo json_encode($matches);
        exit;
    }
    if(isset($_GET['action']) && $_GET['action'] == 'addMatch'){
        // Utilisation des données envoyées depuis le formulaire
        $team1 = $_POST['team1'];
        $team2 = $_POST['team2'];
        $score1 = $_POST['score1'];
        $score2 = $_POST['score2'];
        $matchDate = $_POST['matchDate'];
        $result = $client->addMatch($team1, $team2, $score1, $score2, $matchDate);
        echo json_encode($result);
    }
} catch (SoapFault $exception) {
    // echo "Erreur SOAP : " . $exception->getMessage();
}
?>
