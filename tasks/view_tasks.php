<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

// Obtener el ID del usuario actual
$user_id = $_SESSION['user_id'];

// Obtener el nombre del usuario
$stmt_user = $conn->prepare("SELECT nombre FROM users WHERE id = :user_id");
$stmt_user->bindParam(':user_id', $user_id);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Obtener el nombre del usuario
$stmt_user = $conn->prepare("SELECT username FROM users WHERE id = :user_id");
$stmt_user->bindParam(':user_id', $user_id);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Obtener las tareas del usuario
try {
    $stmt_tasks = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt_tasks->bindParam(':user_id', $user_id);
    $stmt_tasks->execute();
    $tasks = $stmt_tasks->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las tareas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<h1>Mis Tareas - <?php echo htmlspecialchars($user['username']); ?></h1>
    <div class="tareas">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tasks)): ?>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($task['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($task['fecha_creacion']); ?></td>
                    <td><?php echo htmlspecialchars($task['estado']); ?></td>
                    <td>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>">Editar | </a>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay tareas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
    <div class="opciones">
        <a href="create_task.php">Crear Nueva Tarea</a>
        <a href="../users/edit_user.php">Editar Mi Información</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>