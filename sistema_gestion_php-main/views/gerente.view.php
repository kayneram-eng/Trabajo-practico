<?php require_once __DIR__ . '/../auth_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sistema_gestion</title>
    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
<div class="container-fluid mt-4">
    <!-- Header del dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Dashboard Gerencial</h2>
                    <a href="accesos.view.php" class="btn btn-outline-primary mb-3">
    <i class="bi bi-list-check"></i> Ver Registro de Accesos
</a>

                    <p class="text-muted mb-0">
                        <i class="bi bi-person-badge me-1"></i>
                        Bienvenido, <?php echo $_SESSION['usuario'] ?? 'Gerente'; ?>
                    </p>
                </div>
                <div>
                    <a href="../logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Empleados</h6>
                            <h3 class="mb-0"><?php echo $total_empleados ?? 0; ?></h3>
                            <small class="opacity-75">En todo el sistema</small>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people-fill fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Empleados Activos</h6>
                            <h3 class="mb-0"><?php echo $total_empleados_activos ?? 0; ?></h3>
                            <small class="opacity-75">Con acceso al sistema</small>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-check-fill fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Empleados Inactivos</h6>
                            <h3 class="mb-0"><?php echo $total_empleados_inactivos ?? 0; ?></h3>
                            <small class="opacity-75">Sin acceso actual</small>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-x-fill fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Productos</h6>
                            <h3 class="mb-0"><?php echo $total_productos ?? 0; ?></h3>
                            <small class="opacity-75">En inventario</small>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-graph-up-arrow fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gestión de Empleados -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-people-fill me-2"></i>Gestión de Empleados
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- ABM Empleados -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus-fill text-primary fs-1 mb-3"></i>
                                    <h6 class="card-title">ABM Empleados</h6>
                                    <p class="card-text text-muted small">
                                        Crear, editar y eliminar empleados del sistema
                                    </p>
                                    <a href="../index.php?page=gestion_empleados" class="btn btn-primary">
                                        <i class="bi bi-gear-fill me-1"></i>Gestionar
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Empleados Activos -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-check-fill text-success fs-1 mb-3"></i>
                                    <h6 class="card-title">Empleados Activos</h6>
                                    <p class="card-text text-muted small">
                                        Lista de empleados con acceso habilitado
                                    </p>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEmpleadosActivos">
                                        <i class="bi bi-list-check me-1"></i>Ver Lista
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Empleados Inactivos -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-warning h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-dash-fill text-warning fs-1 mb-3"></i>
                                    <h6 class="card-title">Empleados Inactivos</h6>
                                    <p class="card-text text-muted small">
                                        Empleados dados de baja o sin acceso
                                    </p>
                                    <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalEmpleadosInactivos">
                                        <i class="bi bi-list-ul me-1"></i>Ver Lista
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vista de Productos (como empleado) -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-info h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-eye-fill text-info fs-1 mb-3"></i>
                                    <h6 class="card-title">Vista Empleado</h6>
                                    <p class="card-text text-muted small">
                                        Ver productos como los ve un empleado
                                    </p>
                                    <a href="index.php?page=productos" class="btn btn-info">
                                        <i class="bi bi-box-seam me-1"></i>Ver Productos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EMPLEADOS ACTIVOS -->
<div class="modal fade" id="modalEmpleadosActivos" tabindex="-1" aria-labelledby="modalEmpleadosActivosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalEmpleadosActivosLabel">
                    <i class="bi bi-person-check-fill me-2"></i>Empleados Activos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Empleados con estado activo y acceso habilitado al sistema. 
                    <!-- La columna "Historial" muestra el registro de sesiones. -->
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Sesión Activa</th>
                                <!-- <th>Historial</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($empleados_activos) && is_array($empleados_activos)): ?>
    <?php foreach ($empleados_activos as $empleado): ?>
        <tr>
            <td><?= htmlspecialchars($empleado['id']) ?></td>
            <td><?= htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']) ?></td>
            <td><?= htmlspecialchars($empleado['email']) ?></td>
            <td><span class="badge bg-primary"><?= htmlspecialchars($empleado['rol']) ?></span></td>
            <td><span class="badge bg-success">Activo</span></td>
            <td><?= htmlspecialchars($empleado['ultimo_acceso'] ?? 'N/A') ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center text-muted">No hay empleados activos registrados.</td>
    </tr>
<?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EMPLEADOS INACTIVOS -->
<div class="modal fade" id="modalEmpleadosInactivos" tabindex="-1" aria-labelledby="modalEmpleadosInactivosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEmpleadosInactivosLabel">
                    <i class="bi bi-person-dash-fill me-2"></i>Empleados Inactivos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Empleados con estado inactivo. No tienen acceso al sistema hasta que se reactiven.
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-warning">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Inactivación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($empleados_inactivos) && is_array($empleados_inactivos)): ?>
    <?php if (!empty($empleados_inactivos) && is_array($empleados_inactivos)): ?>
    <?php foreach ($empleados_inactivos as $empleado): ?>
        <tr>
            <td><?= htmlspecialchars($empleado['id']) ?></td>
            <td><?= htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']) ?></td>
            <td><?= htmlspecialchars($empleado['email']) ?></td>
            <td><span class="badge bg-primary"><?= htmlspecialchars($empleado['rol']) ?></span></td>
            <td><span class="badge bg-danger">Inactivo</span></td>
            <td><?= htmlspecialchars($empleado['fecha_inactivacion'] ?? 'N/A') ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center text-muted">No hay empleados inactivos registrados.</td>
    </tr>
<?php endif; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center text-muted">No hay empleados inactivos registrados.</td>
    </tr>
<?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HISTORIAL DE SESIONES -->
<div class="modal fade" id="modalHistorialSesiones" tabindex="-1" aria-labelledby="modalHistorialSesionesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalHistorialSesionesLabel">
                    <i class="bi bi-clock-history me-2"></i>Historial de Sesiones - <span id="empleadoNombre">Empleado</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-info">
                            <tr>
                                <th>Fecha</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Duración</th>
                                <th>Estado</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody id="historialSesionesBody">
                            <!-- Datos de ejemplo - aquí se cargarían via AJAX los datos reales -->
                            <tr>
                                <td>2024-03-15</td>
                                <td>08:30:00</td>
                                <td>17:00:00</td>
                                <td>8h 30m</td>
                                <td><span class="badge bg-success">Cerrada</span></td>
                                <td>192.168.1.10</td>
                            </tr>
                            <tr>
                                <td>2024-03-14</td>
                                <td>08:45:00</td>
                                <td>17:15:00</td>
                                <td>8h 30m</td>
                                <td><span class="badge bg-success">Cerrada</span></td>
                                <td>192.168.1.10</td>
                            </tr>
                            <tr>
                                <td>2024-03-13</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td><span class="badge bg-secondary">Sin registro</span></td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>2024-03-12</td>
                                <td>09:00:00</td>
                                <td>16:30:00</td>
                                <td>7h 30m</td>
                                <td><span class="badge bg-success">Cerrada</span></td>
                                <td>192.168.1.10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-download me-1"></i>Exportar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- JQUERY NOTIFICACIONES TOAST y DATATABLE.NET-->
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<!-- ACTUALIZA LOS DATOS DEL DASHBOARD EN TIEMPO REAL (ESTO ESTA RELACIONADO CON ROUTES/WEB.PHP - GERENTE) -->
<script>
function actualizarStats() {
    console.log('🔄 Actualizando estadísticas...');
    
    fetch('index.php?page=gerente&ajax=stats')
        .then(response => response.json())
        .then(data => {
            console.log('✅ Datos recibidos:', data);
            
            // Actualizar todos los empleados
            document.querySelector('.bg-primary h3').textContent = data.empleados;

            // Actualizar empleados activos
            document.querySelector('.bg-success h3').textContent = data.activos;
            
            // Actualizar empleados inactivos
            document.querySelector('.bg-warning h3').textContent = data.inactivos;
            
            // Actualizar productos
            document.querySelector('.bg-info h3').textContent = data.productos;
        })
        .catch(error => {
            console.error('❌ Error:', error);
        });
}

// Actualizar cada 5 segundos
setInterval(actualizarStats, 5000);

console.log('✅ Sistema de actualización automática cargado');
</script>

</body>