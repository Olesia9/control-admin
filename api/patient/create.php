<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


// получаем соединение с базой данных
include_once "../config/database.php";
include_once "../config/methods.php";

// создание объекта записи пациента
$database = new Database();
$db = $database->getConnection();
$product = new Admin($db);

// Получение данных из тела запроса
$data = json_decode(file_get_contents("php://input"));
echo json_encode($data, JSON_UNESCAPED_UNICODE);

// убеждаемся, что данные не пусты
if (
    !empty($data->patient_name) &&
    !empty($data->recording_date) &&
    !empty($data->patient_phone) &&
    !empty($data->doctor_name)
) {
    // устанавливаем значения свойств записи пациента
    $product->patient_name = $data->patient_name;
    $product->recording_date = $data->recording_date;
    $product->patient_phone = $data->patient_phone;
    $product->doctor_name = $data->doctor_name;

    // создание самой записи пациента
    if ($product->create($data->patient_name, $data->patient_phone, $data->recording_date, $data->doctor_name)) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Пациент записан."), JSON_UNESCAPED_UNICODE);
    } // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно записать пациента."), JSON_UNESCAPED_UNICODE);
    }
} // сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно записать пациента. Данные неполные."),  JSON_UNESCAPED_UNICODE);
}