<?php
session_start();
require_once __DIR__ . '/../config.php'; // sube un nivel porque estás dentro de "controllers"

// ✅ Función para registrar cada intento de acceso
function registrar_acceso($pdo, $usuario, $email, $exitoso, $mensaje) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
    $stmt = $pdo->prepare("INSERT INTO accesos (Usuario, Email, IP, Exitoso, Mensaje)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$usuario, $email, $ip, $exitoso ? 1 : 0, $mensaje]);
}

// 🔹 Limpiar y validar entrada del formulario
$usuario = trim($_POST['usuario'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($usuario === '' || $password === '') {
    $_SESSION['error_message'] = 'Por favor, completá todos los campos.';
    registrar_acceso($pdo, $usuario, null, false, 'Campos vacíos');
    header('Location: ../views/login.view.php');
    exit;
}

try {
    // 🔹 Buscar usuario
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE Usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error_message'] = 'Usuario no encontrado.';
        registrar_acceso($pdo, $usuario, null, false, 'Usuario no encontrado');
        header('Location: ../views/login.view.php');
        exit;
    }

    // 🚫 Verificar si está bloqueado
    if (!empty($user['Bloqueado_hasta']) && strtotime($user['Bloqueado_hasta']) > time()) {
        $restante = ceil((strtotime($user['Bloqueado_hasta']) - time()) / 60);
        $_SESSION['error_message'] = "Cuenta bloqueada temporalmente. Intente nuevamente en $restante minutos.";
        registrar_acceso($pdo, $usuario, $user['Email'], false, 'Cuenta bloqueada');
        header('Location: ../views/login.view.php');
        exit;
    }

    // 🔹 Verificar contraseña
    if (!password_verify($password, $user['Contraseña'])) {
        // Aumentar contador de intentos
        $pdo->prepare("UPDATE empleados SET Intentos_fallidos = Intentos_fallidos + 1 WHERE ID = ?")
            ->execute([$user['ID']]);

        // Verificar si alcanzó el límite (5 intentos)
        $user['Intentos_fallidos']++;
        if ($user['Intentos_fallidos'] >= 5) {
            $bloqueo = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            $pdo->prepare("UPDATE empleados SET Bloqueado_hasta = ?, Intentos_fallidos = 0 WHERE ID = ?")
                ->execute([$bloqueo, $user['ID']]);
            $_SESSION['error_message'] = 'Cuenta bloqueada por múltiples intentos fallidos. Espere 15 minutos.';
            registrar_acceso($pdo, $usuario, $user['Email'], false, 'Cuenta bloqueada por intentos fallidos');
        } else {
            $_SESSION['error_message'] = 'Contraseña incorrecta.';
            registrar_acceso($pdo, $usuario, $user['Email'], false, 'Contraseña incorrecta');
        }

        header('Location: ../views/login.view.php');
        exit;
    }

    // ✅ Login exitoso
    $_SESSION['usuario'] = $user['Usuario'];
    $_SESSION['rol_id'] = $user['Rol_ID'];
    $_SESSION['success_message'] = 'Bienvenido, ' . htmlspecialchars($user['Nombre']) . '!';

    // Reiniciar intentos fallidos y bloqueo
    $pdo->prepare("UPDATE empleados SET Intentos_fallidos = 0, Bloqueado_hasta = NULL WHERE ID = ?")
        ->execute([$user['ID']]);

    registrar_acceso($pdo, $user['Usuario'], $user['Email'], true, 'Login exitoso');

    // Redirigir según rol
    if ($user['Rol_ID'] == 1) {
        header('Location: ../views/gerente.view.php');
    } else {
        header('Location: ../views/product.view.php');
    }
    exit;

} catch (PDOException $e) {
    $_SESSION['error_message'] = 'Error en la base de datos: ' . $e->getMessage();
    registrar_acceso($pdo, $usuario, null, false, 'Error DB: ' . $e->getMessage());
    header('Location: ../views/login.view.php');
    exit;
}
