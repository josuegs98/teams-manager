<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Models\Team.php');
session_start();

class TeamController
{
    public $model;
    public $teams;
    public $team;

    public function __construct()
    {
        $this->model = new Team();
    }

    public function index()
    {
        //https://codea.app/blog/mvc-en-php
        $this->teams = $this->model->getAll();
        require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\resources\views\teams\layout.php');
    }

    public function store()
    {
        $this->clearData();

        if($_REQUEST['name'] == "" || $_REQUEST['sport_type'] == "" || $_REQUEST['city'] == "" || $_REQUEST['foundation_date'] == "")
        {
            $_SESSION['operationStatus'] = "error";
            $_SESSION['teamOperationResult'] = "Error: Faltan campos por cubrir";
            header("location:http://localhost/teams-manager/resources/views/teams/layout.php");
        }
        else
        {
            if($this->validateData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $_REQUEST['name']) &&
               $this->validateData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $_REQUEST['city']))
            {
                $insert = $this->model->insert([
                    'name' => $_REQUEST['name'],
                    'sport_type' => $_REQUEST['sport_type'],
                    'city' => $_REQUEST['city'],
                    'foundation_date' => $_REQUEST['foundation_date']
                ]);
    
                if($insert)
                {
                    $_SESSION['operationStatus'] = "success";
                    $_SESSION['teamOperationResult'] = 'Guardado correcto';
                    header("location:http://localhost/teams-manager/resources/views/teams/layout.php");
                }
                else
                {
                    $_SESSION['operationStatus'] = "error";
                    $_SESSION['teamOperationResult'] = 'Error al guardar el registro';
                    header("location:http://localhost/teams-manager/resources/views/teams/layout.php");
                }
            }
            else
            {
                $_SESSION['operationStatus'] = "error";
                $_SESSION['teamOperationResult'] = "Error: Formato inválido de entrada";
                header("location:http://localhost/teams-manager/resources/views/teams/layout.php");
            }
        }
    }

    public function clearData()
    {
        $keyWords = ["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::"];
        foreach($_REQUEST as $key => $value)
        {
            foreach($keyWords as $keyWord){
				$value=str_ireplace($keyWord, "", $value);
			}
            $_REQUEST[$key] = trim($value);
            $_REQUEST[$key] = stripslashes($value);
        }
    }

    public function validateData($pattern, $value)
    {
        if(preg_match("/^".$pattern."$/", $value))
            return true;
        else
            return false;
    }

    public function view()
    {
        $teamId = $_REQUEST['id'];
        return $this->model->getById($teamId)[0];
    }
}