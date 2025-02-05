<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: tasks/view_tasks.php");
} else {
    header("Location: landing.php");
}
?>