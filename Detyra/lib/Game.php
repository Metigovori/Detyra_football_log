
<?php

require_once "./lib/Database.php";

class Game extends Database
{
    private $gamesData;

    public function __construct()
    {
        parent::__construct();
        $this->gamesData = $this->getGamesData();
    }

    public function getGamesData()
    {
        $query = "SELECT * FROM games ORDER BY week DESC";
        $stmt = $this->dbConn->query($query);
        $gamesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $gamesData;
    }

    /* metoda per selektimin e skuadrave me javet me te mira */

    public function getTeamsWithMostAwayGoals()
    {
        $teamsAwayGoalsByWeek = [];

        foreach ($this->gamesData as $game) {
            $awayTeam = $game['away_team'];
            $awayGoals = (int) explode('-', $game['result'])[1];
            $week = (int) $game['week'];

            if (!isset($teamsAwayGoalsByWeek[$awayTeam]) || $awayGoals > $teamsAwayGoalsByWeek[$awayTeam]['goals']) {
                $teamsAwayGoalsByWeek[$awayTeam] = [
                    'week' => $week,
                    'goals' => $awayGoals
                ];
            }
        }

        return $teamsAwayGoalsByWeek;
    }
}
