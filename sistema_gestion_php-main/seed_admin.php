<?php
require_once 'config.php';

try {
    // Generar contraseña segura
    $hash = password_hash('Admin123!', PASSWORD_BCRYPT);

    // Verificar si ya existe un admin
    $check = $pdo->prepare("SELECT * FROM empleados WHERE Usuario = 'admin'");
    $check->execute();

    if ($check->rowCount() > 0) {
        echo "⚠️ Ya existe un usuario admin. No se creó otro.";
        exit;
    }

    // Insertar usuario administrador
    $sql = "INSERT INTO empleados (DNI, Nombre, Apellido, Email, Usuario, Contraseña, Rol_ID, Estado)
            VALUES ('99999999', 'Admin', 'General', 'admin@demo.test', 'admin', ?, 1, 'activo')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$hash]);

    echo "✅ Usuario administrador creado correctamente.<br>";
    echo "Usuario: <b>admin</b> | Contraseña: <b>Admin123!</b>";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
