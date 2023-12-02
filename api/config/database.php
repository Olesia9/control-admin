<?php
//
//class Database
//{
//    // укажите свои учетные данные базы данных
//    private $host = "127.0.0.1";
//    private $db_name = "api_goods_service_db";
//    private $username = "root";
//    private $password = "";
//    public $conn;
//
//    // получаем соединение с БД
//    public function getConnection()
//    {
//        $this->conn = null;
//
//        try {
//            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
//            $this->conn->exec("set names utf8");
//        } catch (PDOException $exception) {
//            echo "Ошибка подключения: " . $exception->getMessage();
//        }
//
//        return $this->conn;
//    }
//}


class Database
{
    // укажите свои учетные данные базы данных
    private $host = "127.0.0.1";
    private $db_name = "med_admin_db";
    private $username = "root";
    private $password = "";
    public $conn;

    // получаем соединение с БД
    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}