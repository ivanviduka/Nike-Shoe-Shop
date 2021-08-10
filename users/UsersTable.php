<?php

class UsersTable
{
    private $conn;
    private $tableName;

    public function __construct()
    {
        $this->tableName = "users";
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

    public function getUser($email)
    {
        $sql = <<<EOSQL
            SELECT email, password FROM $this->tableName WHERE email="$email";
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

    public function getTakenEmails(){
        $sql = <<<EOSQL
            SELECT email FROM $this->tableName;
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

    public function registerUser($first_name, $last_name, $email, $password)
    {
        $todoTask = array(
            ':firstName' => $first_name,
            ':lastName' => $last_name,
            ':email' => $email,
            ':password' => $password
        );

        $sql = <<<EOSQL
        INSERT INTO $this->tableName(first_name, last_name, email, password) VALUES(:firstName, :lastName, :email, MD5(:password));
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
