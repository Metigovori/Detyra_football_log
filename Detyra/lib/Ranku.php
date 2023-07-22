
<?php

require_once "./lib/Database.php";

class Ranku extends Database
{

    private $teamsData;



    public function getRankingTableFromDatabase()
    {
        return $this->getAllData("SELECT * FROM results ORDER BY points DESC");
    }


    public function getRankingTable()
    {
        usort($this->teamsData, function ($a, $b) {
            return $b['points'] - $a['points'];
        });
        return $this->teamsData;
    }
}
