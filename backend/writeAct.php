<?php

include 'connect.php';

$student = $_POST['student'];
$act = $_POST['act'];
$user = $_POST['user']; 
$points = $_POST['points'];

    try {
    // Получаем значение points из act_category
    $sql = "SELECT `points` FROM `act_category` WHERE `id` = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $points, PDO::PARAM_INT);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $pointsValue = $res['points'];


    $sql = "INSERT INTO `history`(`user_id`, `student_id`, `isAct`, `points`) VALUES (:user, :student, 1 , :points)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    $stmt->bindParam(':student', $student, PDO::PARAM_INT);
    $stmt->bindParam(':points', $pointsValue, PDO::PARAM_INT);
    $stmt->execute();

   
    // Обновляем рейтинг
    $sql = "UPDATE rating SET rating = rating - :points WHERE group_id = (SELECT c.shanyrak_id FROM students s JOIN classes c ON s.class_id = c.id WHERE s.id = :student)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':points', $pointsValue, PDO::PARAM_INT);
    $stmt->bindParam(':student', $student, PDO::PARAM_INT);
    $stmt->execute();

    $response = array('success' => 'Data inserted successfully');
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    $response = array('error' => 'Connection error: ' . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

?>