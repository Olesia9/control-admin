<?php
// Устанавливаем заголовки для разрешения CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";
include_once "../config/methods.php";

// получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$product = new Admin($db);

// получаем id записи пациента
$data = json_decode(file_get_contents("php://input"));

// установим id записи пациента для удаления
$product->id = $data->id;

// удаление записи пациента
if ($product->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array("message" => "Запись была удалена"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить товар
else {
    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщим об этом пользователю
    echo json_encode(array("message" => "Не удалось удалить запись пациента"));
}