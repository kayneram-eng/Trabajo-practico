<?php
require_once 'config.php';
session_start();

// --- LOGIN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($usuario === '' || $password === '') {
        die("⚠️ Por favor, completá todos los campos.");
    }

    // Buscar usuario por nombre de usuario
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE Usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("❌ Usuario no encontrado.");
    }

    // Verificar contraseña
    if (!password_verify($password, $user['Contraseña'])) {
        die("❌ Contraseña incorrecta.");
    }

    // Si todo está bien, crear la sesión
    $_SESSION['usuario'] = $user['Usuario'];
    $_SESSION['rol_id'] = $user['Rol_ID'];

    echo "✅ Inicio de sesión exitoso.<br>";
    echo "Bienvenido, " . htmlspecialchars($user['Nombre']) . "!<br>";

    // Redirigir según el rol
    if ($user['Rol_ID'] == 1) {
        header("Refresh: 1; url=gerente.view.php");
    } else {
        header("Refresh: 1; url=product.view.php");
    }

    exit;
}
?>
