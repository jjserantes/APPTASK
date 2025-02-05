<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, titulo, descripcion, estado) VALUES (:user_id, :titulo, :descripcion, :estado)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        header("Location: ../tasks/view_tasks.php");
    } else {
        echo "Error al crear la tarea.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Crear Tarea</h1>
    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        <label for="estado">Estado:</label>
        <select id="estado" name="estado">
            <option value="En proceso">En proceso</option>
            <option value="Terminada">Terminada</option>
        </select>
        <button type="submit">Crear Tarea</button>
    </form>
</body>
</html>