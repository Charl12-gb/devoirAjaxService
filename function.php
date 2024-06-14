<?php

// Désactivation du cache WSDL
ini_set("soap.wsdl_cache_enabled", "0");

class FootballService {
    private $pdo;

    public function __construct() {
        $this->pdo = $this->connectDB();
    }

    private function connectDB() {
        $host = 'localhost';
        $dbname = 'football';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function addMatch($team1, $team2, $score1, $score2, $matchDate) {
        try {
            $sql = "INSERT INTO matches (team1, team2, score1, score2, match_date) VALUES (:team1, :team2, :score1, :score2, :matchDate)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':team1', $team1, PDO::PARAM_STR);
            $stmt->bindParam(':team2', $team2, PDO::PARAM_STR);
            $stmt->bindParam(':score1', $score1, PDO::PARAM_INT);
            $stmt->bindParam(':score2', $score2, PDO::PARAM_INT);
            $stmt->bindParam(':matchDate', $matchDate, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getMatches() {
        try {
            $sql = "SELECT * FROM matches";
            $stmt = $this->pdo->query($sql);
            $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $matches;
        } catch (PDOException $e) {
            return [];
        }
    }
}

try {
    $server = new SoapServer('function.wsdl');
    $server->setClass('FootballService');
    $server->handle();
} catch (Exception $e) {
    echo 'erreur'.$e;
}
?>
