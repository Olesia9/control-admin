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
    ($data->visits === 0 || $data->visits === 1) &&
    !empty($data->id)
) {
// установим значения свойств записи пациента
    $product->visits = $data->visits;
    $product->id = $data->id;

    // обновление записи пациента
    if ($product->updateVisit($data->visits, $data->id)) {

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