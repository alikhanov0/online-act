<?php
include 'connect.php';

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

try {
    $sql = "SELECT * FROM `users` WHERE `username` = :username AND `password` = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    // Проверяем, есть ли пользователь с указанным именем и паролем
    if ($stmt->rowCount() == 1) {
        $_SESSION['loggedIn'] = true;
        
        // Пользователь аутентифицирован
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $response = array('success' => true);
        // Возвращаем JSON-ответ
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['role'] = $user['role'];

        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    } else {
        // Неправильное имя пользователя или пароль
        $response = array('success' => false);
        
        header("Content-Type: application/json");
        // Возвращаем JSON-ответ
        echo json_encode($response);
        exit;
    }
} catch (PDOException $e) {
    // Логируем ошибку
    error_log("Ошибка при выполнении запроса: " . $e->getMessage(), 0);
    
    // Возвращаем JSON-ответ с информацией об ошибке
    $response = array('error' => 'Connection error');
    echo json_encode($response);
    exit;
}
?>
