<?php

include_once "DBConfig.php";

class Crud{
    //instance of our database connection
    private $conn;
    public function __construct()
    {
        $this->conn = getDbConnection();
    }
    public function create($data_array, $table)
    {
        $columns = implode(',', array_keys($data_array));
        $place_holders = ":" . implode(',:', array_keys($data_array));

        $sql = "INSERT INTO $table ($columns) VALUES ($place_holders)";
        //prepare : prepare an sql statement for execution
        $stmt = $this->conn->prepare($sql);
        //insert the data to the database
        $stmt->execute($data_array);
        //return the id of the last
        return $this->conn->lastInsertId();
    }
    public function read($sql_query){
        //run sql statement
        $stmt = $this->conn->prepare($sql_query);
        //execute the statement
        $stmt->execute();
        //return the result found
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function update($sql_query){
        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();

    }
    public function delete($sql_query){
        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();
    }
}