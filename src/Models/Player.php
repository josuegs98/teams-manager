<?php

require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Models\Base.php');

class Player extends Base
{
    public function __construct()
    {
        $this->table = "players";
        $this->fillable = ['name', 'number', 'team_id', 'is_captain'];
        $this->model = "Player";
        
        $config = require (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\config\database.php');
        $this->connection = new \PDO(
            "mysql:host=" . $config['host'] . ";dbname=" . $config['database'],
            $config['username'],
            $config['password']
        );
    }
}