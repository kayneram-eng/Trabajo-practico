<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, lo mandamos al login
    header('Location: ../views/login.view.php');
    exit;
}
?>