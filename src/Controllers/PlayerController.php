<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Models\Player.php');

class PlayerController
{
    public $model;
    public $player;

    public function __construct()
    {
        $this->model = new Player();
    }

    public function index()
    {
        $this->player = $this->model->getById($_REQUEST['id'])[0];
        require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\resources\views\players\edit.php');
    }

    public function store()
    {
        $this->clearData();

        if($_REQUEST['name'] == "" || $_REQUEST['number'] == "")
        {
            $_SESSION['operationStatus'] = "error";
            $_SESSION['teamOperationResult'] = "Error: Faltan campos por cubrir";
            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
        }
        else
        {
            if($this->validateData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $_REQUEST['name']))
            {
                if(isset($_REQUEST['is_captain']))
                {
                    if(!$this->hasCaptain())
                    {
                        $insert = $this->model->insert([
                            'name' => $_REQUEST['name'],
                            'number' => $_REQUEST['number'],
                            'team_id' => $_REQUEST['team_id'],
                            'is_captain' => 1
                        ]);
            
                        if($insert)
                        {
                            $_SESSION['operationStatus'] = "success";
                            $_SESSION['teamOperationResult'] = 'Guardado correcto';
                            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                        }
                        else
                        {
                            $_SESSION['operationStatus'] = "error";
                            $_SESSION['teamOperationResult'] = 'Error al guardar el registro';
                            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                        }
                    }
                    else
                    {
                        $_SESSION['operationStatus'] = "error";
                        $_SESSION['teamOperationResult'] = "Error: El equipo ya tiene un capitán.";
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                }
                else
                {
                    $insert = $this->model->insert([
                        'name' => $_REQUEST['name'],
                        'number' => $_REQUEST['number'],
                        'team_id' => $_REQUEST['team_id'],
                    ]);
        
                    if($insert)
                    {
                        $_SESSION['operationStatus'] = "success";
                        $_SESSION['teamOperationResult'] = 'Guardado correcto';
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                    else
                    {
                        $_SESSION['operationStatus'] = "error";
                        $_SESSION['teamOperationResult'] = 'Error al guardar el registro';
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                }
            }
            else
            {
                $_SESSION['operationStatus'] = "error";
                $_SESSION['teamOperationResult'] = "Error: Formato inválido de entrada";
                header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
            }
        }
    }

    public function update()
    {
        if($_REQUEST['name'] == "" || $_REQUEST['number'] == "")
        {
            $_SESSION['operationStatus'] = "error";
            $_SESSION['teamOperationResult'] = "Error: Faltan campos por cubrir";
            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
        }
        else
        {
            if($this->validateData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $_REQUEST['name']))
            {
                if(isset($_REQUEST['is_captain']))
                {
                    if(!$this->hasCaptain())
                    {
                        $insert = $this->model->update($_REQUEST['player_id'], [
                            'name' => $_REQUEST['name'],
                            'number' => $_REQUEST['number'],
                            'team_id' => $_REQUEST['team_id'],
                            'is_captain' => 1
                        ]);
            
                        if($insert)
                        {
                            $_SESSION['operationStatus'] = "success";
                            $_SESSION['teamOperationResult'] = 'Guardado correcto';
                            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                        }
                        else
                        {
                            $_SESSION['operationStatus'] = "error";
                            $_SESSION['teamOperationResult'] = 'Error al guardar el registro';
                            header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                        }
                    }
                    else
                    {
                        $_SESSION['operationStatus'] = "error";
                        $_SESSION['teamOperationResult'] = "Error: El equipo ya tiene un capitán.";
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                }
                else
                {
                    $insert = $this->model->update($_REQUEST['player_id'], [
                        'name' => $_REQUEST['name'],
                        'number' => $_REQUEST['number'],
                        'team_id' => $_REQUEST['team_id'],
                    ]);
        
                    if($insert)
                    {
                        $_SESSION['operationStatus'] = "success";
                        $_SESSION['teamOperationResult'] = 'Guardado correcto';
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                    else
                    {
                        $_SESSION['operationStatus'] = "error";
                        $_SESSION['teamOperationResult'] = 'Error al guardar el registro';
                        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
                    }
                }
            }
            else
            {
                $_SESSION['operationStatus'] = "error";
                $_SESSION['teamOperationResult'] = "Error: Formato inválido de entrada";
                header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
            }
        }
    }

    public function delete()
    {
        $playerId = $_REQUEST['id'];
        $this->model->deleteById($playerId);
        $_SESSION['operationStatus'] = "success";
        $_SESSION['teamOperationResult'] = 'Jugador eliminado';
        header("location:http://localhost/teams-manager/resources/views/teams/details.php?id=".$_REQUEST['team_id']);
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

    public function hasCaptain()
    {
        $hasCaptain = false;

        $players = $this->model->where('team_id', $_REQUEST['team_id']);
        foreach($players as $player)
        {
            if($player->is_captain && (isset($_REQUEST['player_id'])&& $player->id != $_REQUEST['player_id']))
                $hasCaptain = true;
        }
        return $hasCaptain;
    }
}