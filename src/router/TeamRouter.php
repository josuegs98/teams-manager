<?php

    require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\TeamController.php');
    $controller = new TeamController();

    if(isset($_POST['teams_action']))
    {
        switch ($_POST['teams_action'])
        {
            case 'add':
                echo $controller->store();
                break;
            case 'view':
                header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_POST['id']);
                break;
        }
    }