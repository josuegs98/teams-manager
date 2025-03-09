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
}