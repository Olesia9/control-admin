<?php

class Admin
{
    // подключение к базе данных и таблице "Visits"
    public $conn;
    private $table_name = "Visits";

    // свойства объекта
    public $id;
    public $patient_name;
    public $patient_phone;
    public $recording_date;
    public $doctor_name;
    public $visits;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод для создания данных о записи пациента
    function create($patient_name, $patient_phone, $recording_date, $doctor_name)
    {
        // запрос для вставки (создания) записей
        $query = "INSERT INTO " . $this->table_name . " (patient_name, patient_phone, recording_date, doctor_name, visits, id) VALUES (?, ?, ?, ?, ?, ?)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // привязка значений
        $stmt->bindParam("1", $patient_name);
        $stmt->bindParam("2", $patient_phone);
        $stmt->bindParam("3", $recording_date);
        $stmt->bindParam("4", $doctor_name);
        $stmt->bindParam("5", $this->visits = 0);
        $stmt->bindParam("6", $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод для удаления записи пациента
    function delete()
    {
        // запрос для удаления записи (товара)
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод для получения записи пациентов
    function read()
    {
        // выбираем все записи
        $query = "SELECT * FROM " . $this->table_name;

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    // метод для обновления записи пациентов
    function update($patient_name, $patient_phone, $recording_date, $doctor_name, $visits, $id) {
        $query = "UPDATE "  . $this->table_name .  " SET patient_name=?, patient_phone=?, recording_date=?, doctor_name=?, visits=? WHERE id=?";
        // Подготовленное выражение для обновления данных
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->patient_name = htmlspecialchars(strip_tags($this->patient_name));
        $this->patient_phone = htmlspecialchars(strip_tags($this->patient_phone));
        $this->recording_date = htmlspecialchars(strip_tags($this->recording_date));
        $this->doctor_name = htmlspecialchars(strip_tags($this->doctor_name));
        $this->visits = htmlspecialchars(strip_tags($this->visits));

        // привязываем значения
        $stmt->bindParam("1", $patient_name);
        $stmt->bindParam("2", $patient_phone);
        $stmt->bindParam("3", $recording_date);
        $stmt->bindParam("4", $doctor_name);
        $stmt->bindParam("5", $visits);
        $stmt->bindParam("6", $id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}