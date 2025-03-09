<?php

    require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\TeamController.php');
    require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\PlayerController.php');
    $teamController = new TeamController();
    $playerController = new PlayerController();

    if(isset($_POST['teams_action']))
    {
        switch ($_POST['teams_action'])
        {
            case 'add':
                echo $teamController->store();
                break;
            case 'view':
                header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_POST['id']);
                break;
            case 'addPlayer':
                echo $playerController->store();
                break;
            case 'deletePlayer':
                echo $playerController->delete();
                break;
            case 'updatePlayer':
                header("location:http://localhost/teams-manager/resources/views/players/edit.php?id=".$_POST['id']."&team_id=".$_POST['team_id']);
                break;
            case 'savePlayerChanges':
                echo $playerController->update();
                break;
        }
    }