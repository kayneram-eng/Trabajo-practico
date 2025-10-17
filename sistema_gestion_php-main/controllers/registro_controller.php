<?php
session_start();
require_once __DIR__ . '/../config.php';

// 🔹 Función para validar contraseña fuerte
function validar_password($password) {
    $tieneMayus = preg_match('/[A-Z]/', $password);
    $tieneNumero = preg_match('/[0-9]/', $password);
    $tieneSimbolo = preg_match('/[^A-Za-z0-9]/', $password);
    return strlen($password) >= 8 && $tieneMayus && $tieneNumero && $tieneSimbolo;
}

// 🔹 Procesar el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $perfil  = trim($_POST['perfil'] ?? '');

    // Validaciones básicas
    if ($usuario === '' || $email === '' || $password === '' || $perfil === '') {
        $_SESSION['error_message'] = 'Todos los campos son obligatorios.';
        header('Location: ../views/registro.view.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'El formato del correo no es válido.';
        header('Location: ../views/registro.view.php');
        exit;
    }

    if (!validar_password($password)) {
        $_SESSION['error_message'] = 'La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un símbolo.';
        header('Location: ../views/registro.view.php');
        exit;
    }

    try {
        // Verificar duplicados
        $check = $pdo->prepare("SELECT * FROM empleados WHERE Usuario = ? OR Email = ?");
        $check->execute([$usuario, $email]);
        if ($check->fetch()) {
            $_SESSION['error_message'] = 'El usuario o correo ya existe.';
            header('Location: ../views/registro.view.php');
            exit;
        }

        // Encriptar contraseña
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Rol_ID: 1=Gerente, 2=Empleado
        $rol = ($perfil === 'Gerente') ? 1 : 2;

        // Insertar nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO empleados (DNI, Nombre, Apellido, Email, Usuario, Contraseña, Rol_ID, Estado)
                               VALUES ('00000000', 'Nuevo', 'Usuario', ?, ?, ?, ?, 'activo')");
        $stmt->execute([$email, $usuario, $hash, $rol]);

        $_SESSION['success_message'] = 'Usuario registrado correctamente. Ahora puedes iniciar sesión.';
        header('Location: ../views/login.view.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error al registrar el usuario: ' . $e->getMessage();
        header('Location: ../views/registro.view.php');
        exit;
    }
}
