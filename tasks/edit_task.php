<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("UPDATE tasks SET titulo = :titulo, descripcion = :descripcion, estado = :estado WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        header("Location: ../tasks/view_tasks.php");
    } else {
        echo "Error al actualizar la tarea.";
    }
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$task = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Editar Tarea</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $task['titulo']; ?>" required>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $task['descripcion']; ?></textarea>
        <label for="estado">Estado:</label>
        <select id="estado" name="estado">
            <option value="En proceso" <?php echo ($task['estado'] == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
            <option value="Terminada" <?php echo ($task['estado'] == 'Terminada') ? 'selected' : ''; ?>>Terminada</option>
        </select>
        <button type="submit">Actualizar Tarea</button>
    </form>
</body>
</html>