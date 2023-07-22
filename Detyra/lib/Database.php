<?php

require_once "./config/config.php";

abstract class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    protected $dbConn;

    public function __construct()
    {
        $this->connectDB();
    }

    private function connectDB()
    {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConn = $pdo;
        } catch (Exception $e) {
            echo "Connection to the database failed: " . $e->getMessage();
        }
    }

    public function insertGamesData($gamesData)
    {
        $DB = $this->dbConn;

        foreach ($gamesData as $game) {
            $homeTeam = $DB->quote($game['t1']);
            $awayTeam = $DB->quote($game['t2']);
            $week = (int)$game['week'];
            $result = $DB->quote($game['result']);

            $query = "INSERT INTO games (home_team, away_team, week, result) VALUES ($homeTeam, $awayTeam, $week, $result)";
            $DB->query($query);
        }
    }

    public function insertResultsData($resultsData)
    {
        try {
            foreach ($resultsData as $result) {
                $team = $this->dbConn->quote($result['team']);
                $matches = (int)$result['matches'];
                $wins = (int)$result['wins'];
                $draws = (int)$result['draws'];
                $losses = (int)$result['looses'];
                $points = (int)$result['points'];

                $query = "INSERT INTO results (team, matches, wins, draws, losses, points) VALUES ($team, $matches, $wins, $draws, $losses, $points)";
                $this->dbConn->query($query);
            }
        } catch (PDOException $e) {
            echo "Error occurred while inserting data into the results table: " . $e->getMessage();
        }
    }

    public function getAllData()
    {
        try {
            // Fetch data from the games table
            $gamesData = [];
            $query = "SELECT * FROM games";
            $stmt = $this->dbConn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $gamesData[] = [
                    't1' => $row['home_team'],
                    't2' => $row['away_team'],
                    'week' => $row['week'],
                    'result' => $row['result']
                ];
            }

            // Fetch data from the results table
            $resultsData = [];
            $query = "SELECT * FROM results";
            $stmt = $this->dbConn->query($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultsData[] = [
                    'team' => $row['team'],
                    'matches' => (int)$row['matches'],
                    'wins' => (int)$row['wins'],
                    'draws' => (int)$row['draws'],
                    'looses' => (int)$row['losses'],
                    'points' => (int)$row['points']
                ];
            }

            $data = [
                'gamesData' => $gamesData,
                'resultsData' => $resultsData
            ];

            return $data;
        } catch (PDOException $e) {
            echo "Error occurred while fetching data: " . $e->getMessage();
            return [];
        }
    }
}
