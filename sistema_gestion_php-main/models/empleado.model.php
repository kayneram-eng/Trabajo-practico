<?php
require_once __DIR__ . '../../config.php';

class EmpleadoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; // RECIBE LA CONEXION PDO DESDE AFUERA
    }

    // OBTENEMOS TODO LOS EMPLEADOS TIENE UN INNER JOIN PARA MOSTRAR LOS ROLES EN LAS TABLAS
    public function getAll() {
    $stmt = $this->pdo->query("
        SELECT 
            empleados.ID AS id,
            empleados.DNI AS dni,
            empleados.Nombre AS nombre,
            empleados.Apellido AS apellido,
            empleados.Fecha_nacimiento AS fecha_nacimiento,
            empleados.Email AS email,
            empleados.Contraseña AS contraseña,
            empleados.Rol_ID AS rol_id,
            roles.Nombre AS rol,
            empleados.Estado AS estado,
            empleados.Creado AS creacion,
            empleados.Actualizado AS actualizado,
            empleados.Intentos_fallidos AS Intentos_fallidos,
            empleados.Bloqueado_hasta AS Bloqueado_hasta
        FROM empleados
        INNER JOIN roles ON empleados.Rol_ID = roles.ID
        ORDER BY empleados.ID ASC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // OBTENEMOS UN EMPLEADO POR ID TIENE UN INNER JOIN PARA MOSTRA LOS ROLES NE LAS TABLAS
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT empleados.ID as id, empleados.DNI as dni, empleados.Nombre as nombre, empleados.Apellido as apellido, empleados.Email as email, empleados.Contraseña as contraseña, empleados.Rol_ID as rol_id, roles.Nombre as rol, empleados.Estado as estado, empleados.Sesion_activa as sesion_activa, empleados.Ultimo_acceso as ultimo_acceso FROM empleados INNER JOIN roles ON empleados.Rol_ID = roles.ID WHERE empleados.ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // CREAMOS NUEVO EMPLEADO
    public function create($dni, $nombre, $apellido, $fecha_nacimiento, $email, $contraseña, $rol_id, $estado) {
    $stmt = $this->pdo->prepare("INSERT INTO empleados (DNI, Nombre, Apellido, Fecha_nacimiento, Email, Contraseña, Rol_ID, Estado) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$dni, $nombre, $apellido, $fecha_nacimiento, $email, $contraseña, $rol_id, $estado]);
}

    // ACTUALIZAMOS DATOS DEL EMPLEADO
    public function update($id, $dni, $nombre, $apellido, $fecha_nacimiento, $email, $contraseña, $rol_id, $estado) {
    $stmt = $this->pdo->prepare("UPDATE empleados 
                                 SET DNI=?, Nombre=?, Apellido=?, Fecha_nacimiento=?, Email=?, Contraseña=?, Rol_ID=?, Estado=? 
                                 WHERE ID=?");
    return $stmt->execute([$dni, $nombre, $apellido, $fecha_nacimiento, $email, $contraseña, $rol_id, $estado, $id]);
}

    // ELIMINAMOS EMPLEADO
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM empleados WHERE ID=?");
        return $stmt->execute([$id]);
    }
}

?>