<?php
session_start();
require_once __DIR__ . '/../config.php';

// Verificar que el usuario actual tenga permisos (Gerente o Superadmin)
if (!isset($_SESSION['usuario']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 0)) {
    http_response_code(403);
    die('Acceso denegado.');
}

// Verificar que llegue el parámetro ID
if (!isset($_GET['id'])) {
    die('ID de usuario no especificado.');
}

$id = (int) $_GET['id'];

// Obtener datos del usuario desbloqueado (para registrar en accesos)
$stmt = $pdo->prepare("SELECT Usuario, Email FROM empleados WHERE ID = ?");
$stmt->execute([$id]);
$usuarioDesbloqueado = $stmt->fetch(PDO::FETCH_ASSOC);

// Desbloquear el usuario
$stmt = $pdo->prepare("UPDATE empleados SET Intentos_fallidos = 0, Bloqueado_hasta = NULL WHERE ID = ?");
$stmt->execute([$id]);

// ✅ Registrar el desbloqueo en la tabla de accesos
$adminUsuario = $_SESSION['usuario'] ?? 'Desconocido';
$mensaje = "El administrador '$adminUsuario' desbloqueó la cuenta de '{$usuarioDesbloqueado['Usuario']}'";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';

$stmt = $pdo->prepare("INSERT INTO accesos (Usuario, Email, IP, Exitoso, Mensaje)
                       VALUES (?, ?, ?, 1, ?)");
$stmt->execute([$adminUsuario, $usuarioDesbloqueado['Email'], $ip, $mensaje]);

// Mensaje para el panel
$_SESSION['success_message'] = '✅ Usuario desbloqueado correctamente y registrado en auditoría.';

// Redirigir al router (para que cargue correctamente la vista)
header('Location: /sistema_gestion_php-main/index.php?page=gestion_empleados');
exit;
