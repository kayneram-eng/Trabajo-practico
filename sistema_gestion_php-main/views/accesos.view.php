<?php
require_once __DIR__ . '/../auth_check.php';
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Accesos</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-light p-4">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary"><i class="bi bi-list-check"></i> Registro de Accesos</h2>
            <a href="gerente.view.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table id="tablaAccesos" class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Resultado</th>
                            <th>Mensaje</th>
                            <th>Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM accesos ORDER BY ID DESC");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $resultado = $row['Exitoso'] ? 
                                '<span class="badge bg-success">Éxito</span>' : 
                                '<span class="badge bg-danger">Falla</span>';

                            echo "<tr>
                                <td>{$row['ID']}</td>
                                <td>{$row['Usuario']}</td>
                                <td>{$row['Email']}</td>
                                <td>{$row['IP']}</td>
                                <td>{$resultado}</td>
                                <td>{$row['Mensaje']}</td>
                                <td>{$row['Creado']}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS DATATABLES -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#tablaAccesos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            order: [[0, 'desc']]
        });
    });
    </script>
</body>
</html>
