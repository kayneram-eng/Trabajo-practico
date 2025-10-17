<?php require __DIR__ . '/layouts/header.php' ?>

<div class="container mt-4 mb-5">
    <h1 class="mb-4">Gestión de Empleados</h1>
    <div class="mb-3">
    <label for="buscarEmail" class="form-label fw-bold">Buscar por Email:</label>
    <input type="text" id="buscarEmail" class="form-control" placeholder="Escriba un correo o parte del correo...">
</div>


    <!-- BOTON NUEVO PRODUCTO -->
    <button class="btn btn-success mb-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#modalCrear">
        + Nuevo Empleado
    </button>

    <!-- TABLA DE PRODUCTOS -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped display" id="tabla">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <!-- <th>Sesión Activa</th>
                    <th>Último Acceso</th> -->
                    <th>Creado</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['id']) ?></td>
                        <td><?= htmlspecialchars($e['dni']) ?></td>
                        <td><?= htmlspecialchars($e['nombre']) ?></td>
                        <td><?= htmlspecialchars($e['apellido']) ?></td>
                        <td><?= htmlspecialchars($e['fecha_nacimiento']) ?></td>
                        <td><?= htmlspecialchars($e['email']) ?></td>
                        <td><?= htmlspecialchars($e['contraseña']) ?></td>
                        <td><span class="badge bg-primary"><?= htmlspecialchars($e['rol']) ?></span></td>
                        <td>
                            <?php if ($e['estado'] === 'activo'): ?>
                                <span class="badge bg-success">activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">inactivo</span>
                            <?php endif; ?>
                            <?php if (!empty($e['Bloqueado_hasta']) && strtotime($e['Bloqueado_hasta']) > time()): ?>
    <span class="badge bg-warning text-dark">bloqueado</span>
<?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($e['creacion']) ?></td>
                        <td><?= htmlspecialchars($e['actualizado']) ?></td>
                        <td class="d-flex gap-3">
    <!-- BOTON EDITAR -->
    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $e['id'] ?>">Editar</button>
    <!-- BOTON ELIMINAR -->
    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar<?= $e['id'] ?>">Eliminar</button>

    <?php if (!empty($e['Bloqueado_hasta']) && strtotime($e['Bloqueado_hasta']) > time()): ?>
        <!-- BOTON DESBLOQUEAR -->
        <a href="/sistema_gestion_php-main/index.php?page=desbloquear_usuario&id=<?= $e['id'] ?>"
   class="btn btn-success btn-sm"
   onclick="return confirm('¿Seguro que deseas desbloquear la cuenta de <?= htmlspecialchars($e['nombre']) ?>?');">
   🔓 Desbloquear
</a>

</a>
    <?php endif; ?>
</td>
                    </tr>

                    <!-- MODAL EDITAR -->
                    <div class="modal fade" id="modalEditar<?= $e['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="index.php?page=gestion_empleados" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Empleado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">DNI</label>
                                            <input type="text" name="dni" class="form-control" value="<?= htmlspecialchars($e['dni']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($e['nombre']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apellido</label>
                                            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($e['apellido']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Fecha de nacimiento</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($e['fecha_nacimiento']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <textarea name="email" class="form-control"><?= htmlspecialchars($e['email']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" name="contraseña" class="form-control" value="<?= htmlspecialchars($e['contraseña']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_rol_id" class="form-label">Rol ID<span class="text-danger">*</span></label>
                                            <select class="form-select" id="edit_rol_id" name="rol_id" value="<?= htmlspecialchars($e['rol']) ?>" required>
                                                <option value="1">Jefe</option>
                                                <option value="2">Empleado</option>
                                            </select>
                                        </div>
                                        <label for="edit_estado" class="form-label">Estado<span class="text-danger">*</span></label>
                                        <select class="form-select" id="edit_estado" name="estado" value="<?= htmlspecialchars($e['estado']) ?>" required>
                                            <option value="activo">Activo</option>
                                            <option value="inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="update" class="btn btn-success">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL ELIMINAR -->
                    <div class="modal fade" id="modalEliminar<?= $e['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <form action="index.php?page=gestion_empleados" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                        ¿Seguro que deseas eliminar a: <strong><?= htmlspecialchars($e['nombre']) ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Nuevo Empleado -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrear" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrear">Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoEmpleado" action="index.php?page=gestion_empleados" method="POST">
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol" name="rol_id" required>
                            <option value="1">Gerente</option>
                            <option value="2">Empleado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <select class="form-select" name="estado" id="estado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="create" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php Toast::show() ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabla = $('#tabla').DataTable(); // Usa la tabla existente de DataTables
    const inputBuscar = document.getElementById('buscarEmail');

    inputBuscar.addEventListener('keyup', function() {
        tabla.column(4).search(this.value).draw(); // Columna 4 = Email
    });
});
</script>


<?php require __DIR__ . '/layouts/footer.php' ?>