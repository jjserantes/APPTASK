<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header("Location: ../tasks/view_tasks.php");
} else {
    echo "Error al eliminar la tarea.";
}

header("Location: view_tasks.php");
?>