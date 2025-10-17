<?php require __DIR__ . '/layouts/header.php' ?>

<div class="container mt-4 mb-5">
    <h1 class="mb-4">Gestión de Productos</h1>

    <!-- BOTON NUEVO PRODUCTO -->
    <button class="btn btn-success mb-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#modalCrear">
        + Nuevo Producto
    </button>

    <!-- TABLA DE PRODUCTOS -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped display" id="tabla">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Nombre</th>
                    <th>Presentacion</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Creacion</th>
                    <th>Actualizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['animal']) ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['presentacion']) ?></td>
                    <td><?= htmlspecialchars($p['descripcion']) ?></td>
                    <td>$<?= number_format($p['precio'],2) ?></td>
                    <td><?= htmlspecialchars($p['stock']) ?></td>
                    <td><?= htmlspecialchars($p['creacion']) ?></td>
                    <td><?= htmlspecialchars($p['actualizacion']) ?></td>
                    <td class="d-flex gap-3">
                        <!-- BOTON EDITAR -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $p['id'] ?>">Editar</button>
                        <!-- BOTON ELIMINAR -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar<?= $p['id'] ?>">Eliminar</button>
                    </td>
                </tr>

                <!-- MODAL EDITAR -->
                <div class="modal fade" id="modalEditar<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="index.php?page=productos" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Animal</label>
                                        <input type="text" name="animal" class="form-control" value="<?= htmlspecialchars($p['animal']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($p['nombre']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Presentacion</label>
                                        <input type="text" name="presentacion" class="form-control" value="<?= htmlspecialchars($p['presentacion']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="descripcion" class="form-control"><?= htmlspecialchars($p['descripcion']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Precio</label>
                                        <input type="number" step="0.01" name="precio" class="form-control" value="<?= $p['precio'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" value="<?= $p['stock'] ?>" required>
                                    </div>
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
                <div class="modal fade" id="modalEliminar<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <form action="index.php?page=productos" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    ¿Seguro que deseas eliminar <strong><?= htmlspecialchars($p['nombre']) ?></strong>?
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

<!-- MODAL CREAR PRODUCTO -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="index.php?page=productos" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Animal</label>
                        <input type="text" name="animal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Presentacion</label>
                        <input type="text" name="presentacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="create" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php Toast::show() ?>
<?php require __DIR__ . '/layouts/footer.php' ?>