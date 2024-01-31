<?php
// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once "../config/database.php";
include_once "../config/methods.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$product = new Admin($db);

// получаем id записи пациента для редактирования
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->patient_name) &&
    !empty($data->recording_date) &&
    !empty($data->patient_phone) &&
    !empty($data->doctor_name)
) {
// установим значения свойств записи пациента
    $product->patient_name = $data->patient_name;
    $product->patient_phone = $data->patient_phone;
    $product->recording_date = $data->recording_date;
    $product->doctor_name = $data->doctor_name;
    $product->visits = $data->visits;
    $product->id = $data->id;
    // обновление записи пациента
    if ($product->update($data->patient_name, $data->patient_phone, $data->recording_date, $data->doctor_name, $data->visits, $data->id)) {
        // установим код ответа - 200 ok
        http_response_code(200);
        // сообщим пользователю
        echo json_encode(array("message" => "Запись пациента была обновлена"), JSON_UNESCAPED_UNICODE);
    } // если не удается обновить товар, сообщим пользователю
    else {
        // код ответа - 503 Сервис не доступен
        http_response_code(503);
        // сообщение пользователю
        echo json_encode(array("message" => "Невозможно обновить запись пациента"), JSON_UNESCAPED_UNICODE);
    }
}
else {
    // код ответа - 400 Сервис не доступен
    http_response_code(400);
    // сообщение пользователю
    echo json_encode(array("message" => "Некорректные данные"), JSON_UNESCAPED_UNICODE);
}