<?php

$servername = "localhost"; // Адрес сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль пользователя базы данных
$database = "act"; // Имя базы данных
$conn="";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Устанавливаем режим ошибок PDO на исключения
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Здесь можно выполнять операции с базой данных

} catch(PDOException $e) {
}

?>