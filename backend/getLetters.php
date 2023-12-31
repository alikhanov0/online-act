<?php

include 'connect.php';

$grade = $_POST['grade'];

try {
    $sql = "SELECT `liter` FROM `classes` WHERE `grade` = :grade";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':grade', $grade, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Логируем ошибку
    error_log("Ошибка при выполнении запроса: " . $e->getMessage(), 0);
    
    // Возвращаем JSON-ответ с информацией об ошибке
    $response = array('error' => 'Connection error');
    echo json_encode($response);
    exit;
}

?>