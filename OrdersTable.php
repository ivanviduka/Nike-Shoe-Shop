<?php

class OrdersTable
{
    private $conn;
    private $tableName;

    public function __construct()
    {
        $this->tableName = "orders";
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


    public function getUsersOrders($email)
    {
        $todoTask = array(
            ':email' => $email
        );

        $sql = <<<EOSQL
            SELECT * FROM $this->tableName WHERE email=:email;
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

    public function createOrder($city, $address, $phone_number, $email, $total_price, $order_info)
    {

        $timestamp = mt_rand(strtotime("+2 weeks"), strtotime("+4 weeks"));
        $randomDate = date("Y-m-d", $timestamp);


        $todoTask = array(
            ':city' => $city,
            ':address' => $address,
            ':phone_number' => $phone_number,
            ':email' => $email,
            ':total_price' => $total_price,
            ':order_info' => $order_info,
            ':current_time' => $randomDate
        );

        $sql = <<<EOSQL
        INSERT INTO $this->tableName(city, address, phone_number, email, total_price, order_info, arrival_date) VALUES(:city, :address, :phone_number, :email, :total_price, :order_info, :current_time);
        EOSQL;

        $query = $this->conn->prepare($sql);

        try {
            $query->execute($todoTask);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteOrder($orderID)
    {
        $todoTask = array(
            ':id' => $orderID
        );

        $sql = <<<EOSQL
        DELETE FROM $this->tableName WHERE id=:id;
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
