# CRUD функционал для системы контроля пациентов 

---

*Задача из практики, 2 курс*

Чтобы создать таблицу выполните sql запрос:
```
CREATE TABLE recording (
id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id),
patient_name VARCHAR(255) NOT NULL,
patient_phone VARCHAR(11) NOT NULL,
recording_date DATE NOT NULL,
doctor_name VARCHAR(255) NOT NULL,
visits TINYINT(1) CHECK (is_active IN (0, 1)) );
```

Запросы через постман:  
1. Create
```
curl --location 'http://ВАШ_ДОМЕН/control-admin/api/patient/create.php' \
--header 'Content-Type: application/json' \
--data '{
    "patient_name": "Зазулин А.К.",
    "patient_phone": 89930167320,
    "recording_date": "22.12.2023",
    "doctor_name": "Авантирова Е.Е."
}'
```

2. Read
```
curl --location 'http://ВАШ_ДОМЕН/control-admin/api/patient/read.php'
```

3. Update
```
curl --location --request PUT 'http://ВАШ_ДОМЕН/control-admin/api/patient/update.php' \
--header 'Content-Type: application/json' \
--data '{
    "patient_name": "Зазулин А.К.",
    "patient_phone": 89930167320,
    "recording_date": "22.12.2023",
    "doctor_name": "Авантирова Е.Е.",
    "visits": "1",
    "id": "1"
}'
```

4. Delete
```
curl --location --request GET 'http://ВАШ_ДОМЕН/control-admin/api/patient/delete.php' \
--header 'Content-Type: application/json' \
--data '{
    "id": "2"
}'
```

*Использовалось:*   
phpMyAdmin - создание бд и отслеживание изменений;   
postman - тестирование запросов;   
Open Server Panel - локальный сервер
