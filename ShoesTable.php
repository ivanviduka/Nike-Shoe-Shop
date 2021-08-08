<?php

class ShoesTable
{
    private $conn;
    private $tableName;

    public function __construct()
    {
        $this->tableName = "shoes";
        try {
            $this->conn = new PDO(
                "mysql:host=" . DBConfig::HOST . ";dbname=" . DBConfig::DB_NAME,
                DBConfig::USERNAME,
                DBConfig::PASS
            );
        } catch (PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function getShoes()
    {
        $sql = <<<EOSQL
            SELECT * FROM $this->tableName;
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getSelectedShoes($shoesID)
    {
        $todoTask = array(
            ':id' => $shoesID
        );

        $sql = <<<EOSQL
            SELECT * FROM $this->tableName WHERE id=:id;
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}