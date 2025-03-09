<?php

class Base
{
    public function __construct(protected $table, protected $fillable, protected $connection, protected $model)
    {}

    public function getAll()
    {
        $sql = $this->connection->query("SELECT * FROM $this->table");
        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    public function getById($id)
    {
        $sql = $this->connection->query("SELECT * FROM $this->table WHERE id = $id");

        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    public function deleteById($id)
    {
        $sql = $this->connection->query("DELETE FROM $this->table WHERE id = $id");

        return $sql;
    }

    public function where($column, $value)
    {
        $sql = $this->connection->query("SELECT * FROM $this->table WHERE $column = $value");
       
        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert($values)
    {
        $columns = "";
        $queryValues = "";
        foreach($this->fillable as $attribute)
        {
            $columns .= $attribute.',';
            $queryValues .= "'".$values[$attribute]."',";
        }
        $columns = rtrim($columns, ',');
        $queryValues = rtrim($queryValues, ',');

        $query = "INSERT INTO $this->table ($columns) VALUES ($queryValues)";
        try
        {
            $sql = $this->connection->query($query);
            return $sql;
        }
        catch(Exception $e)
        {
            return false; 
        }
    }

    public function update($id, $values)
    {
        $queryValues = "";
        foreach($this->fillable as $attribute)
        {
            $queryValues .= "$attribute = '$values[$attribute]',";
        }
        $queryValues = rtrim($queryValues, ',');

        $query = "UPDATE $this->table SET $queryValues WHERE id = $id";
        try
        {
            $sql = $this->connection->query($query);
            return $sql;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}