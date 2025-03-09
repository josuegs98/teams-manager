<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Models\Base.php');

class Team extends Base
{
    const TYPES = [0 => 'Fútbol', 1 => 'Baloncesto', 2 => 'Tenis', 3 => 'Waterpolo', 4 => 'Rugby'];

    public function __construct()
    {
        $this->table = "teams";
        $this->fillable = ['name', 'sport_type', 'city', 'foundation_date'];
        $this->model = "Team";
        
        $config = require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\config\database.php');
        $this->connection = new \PDO(
            "mysql:host=" . $config['host'] . ";dbname=" . $config['database'],
            $config['username'],
            $config['password']
        );
    }

    public function getCaptain($team_id)
    {
        $sql = $this->connection->query("SELECT * FROM players WHERE team_id = $team_id AND is_captain = 1");
        return $sql->fetchAll(PDO::FETCH_CLASS)[0];
    }

    public function getPlayers($team_id)
    {
        $sql = $this->connection->query("SELECT * FROM players WHERE team_id = $team_id");
        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    
    public function getDetailedName($team_id)
    {
        $team = $this->getById($team_id)[0];
        return $team->name.' / '.$this::TYPES[$team->sport_type];
    }
}