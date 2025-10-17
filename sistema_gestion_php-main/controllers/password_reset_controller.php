<?php
session_start();
require_once __DIR__ . '/../config.php';

// Paso 1: Solicitar token
if (isset($_POST['solicitar'])) {
    $usuario = trim($_POST['usuario'] ?? '');

    if ($usuario === '') {
        $_SESSION['error_message'] = 'Ingresá tu usuario.';
        header('Location: ../views/forgot_password.view.php');
        exit;
    }

    // Verificar que el usuario exista
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE Usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error_message'] = 'Usuario no encontrado.';
        header('Location: ../views/forgot_password.view.php');
        exit;
    }

    // Generar token y guardarlo
    $token = bin2hex(random_bytes(16)); // 32 caracteres
    $pdo->prepare("DELETE FROM password_resets WHERE Usuario = ?")->execute([$usuario]);
    $pdo->prepare("INSERT INTO password_resets (Usuario, Token, Expira)
                   VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))")->execute([$usuario, $token]);

    $_SESSION['success_message'] = "Tu token de recuperación es: <b>$token</b><br>Válido por 15 minutos.";
    header('Location: ../views/reset_password.view.php');
    exit;
}

// Paso 2: Restablecer contraseña
if (isset($_POST['resetear'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $token = trim($_POST['token'] ?? '');
    $nueva = trim($_POST['nueva'] ?? '');

    // Validar token y contraseña
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE Usuario = ? AND Token = ?");
    $stmt->execute([$usuario, $token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || strtotime($row['Expira']) < time()) {
        $_SESSION['error_message'] = 'Token inválido o vencido.';
        header('Location: ../views/reset_password.view.php');
        exit;
    }

    // Validar fuerza de contraseña
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/', $nueva)) {
        $_SESSION['error_message'] = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.';
        header('Location: ../views/reset_password.view.php');
        exit;
    }

    // Actualizar contraseña
    $hash = password_hash($nueva, PASSWORD_BCRYPT);
    $pdo->prepare("UPDATE empleados SET Contraseña = ? WHERE Usuario = ?")->execute([$hash, $usuario]);
    $pdo->prepare("DELETE FROM password_resets WHERE Usuario = ?")->execute([$usuario]);

    $_SESSION['success_message'] = 'Contraseña actualizada correctamente. Ya podés iniciar sesión.';
    header('Location: ../views/login.view.php');
    exit;
}
