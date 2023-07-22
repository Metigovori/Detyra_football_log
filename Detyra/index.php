<?php
include './inc/header.php';
require "./lib/Database.php";
require "./lib/Ranku.php";
require "./lib/Game.php";

$ranku = new Ranku();

// marrja e rank listes
$rankingTable = $ranku->getRankingTableFromDatabase();

// marrja e te gjitha te dhenav nga tabela games
$gamesData = $ranku->getAllData('games');

$resultsData = $ranku->getAllData('results');




?>

<!-- Tabela e lojeve  -->
<div class="container mt-4">
    <h2>Games Table</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Home Team</th>
                <th>Away Team</th>
                <th>Week</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gamesData['gamesData'] as $game) : ?>
                <tr>
                    <td><?= $game['t1']; ?></td>
                    <td><?= $game['t2']; ?></td>
                    <td><?= $game['week']; ?></td>
                    <td><?= $game['result']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Rank Tabela -->
<div class="container mt-4">
    <h2>Ranking Table</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Team</th>
                <th>Matches</th>
                <th>Wins</th>
                <th>Draws</th>
                <th>Losses</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultsData['resultsData'] as $teamData) : ?>
                <tr>
                    <td><?= $teamData['team']; ?></td>
                    <td><?= $teamData['matches']; ?></td>
                    <td><?= $teamData['wins']; ?></td>
                    <td><?= $teamData['draws']; ?></td>
                    <td><?= $teamData['looses']; ?></td>
                    <td><?= $teamData['points']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Java me e mir e skuadrave miqesore -->
<div class="container mt-4">
    <h2>Top week with the most goals for each away team</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Away Team</th>
                <th>Week With Most Goals</th>
                <th>Goals</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $game = new Game();


            $teamsWithMostAwayGoals = $game->getTeamsWithMostAwayGoals();


            foreach ($teamsWithMostAwayGoals as $awayTeam => $data) {
                echo "<tr>";
                echo "<td>{$awayTeam}</td>";
                echo "<td>{$data['week']}</td>";
                echo "<td>{$data['goals']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include "./inc/footer.php"; ?>