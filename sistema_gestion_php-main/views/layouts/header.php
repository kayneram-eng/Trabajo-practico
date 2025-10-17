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
    <!-- NOTIFICACIONES TOAST -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- DATATABLES JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.css">
    <!-- DATATABLES JS BUTTONS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.bootstrap5.css">

    <!-- NOTIFICAION TOAST -->
    <style>
        /* Quita la imagen que viene por defecto*/
        #toast-container>.toast {
            background-image: none !important;
        }

        /* Quitar espaciado del icono */
        #toast-container .toast {
            padding: 15px 15px 15px 15px !important;
        }

        /* Ordena el datatable de Datatables.net - Se lo ponen y queda feo */
        .row>* {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Mediaqueries */
        /* Sobrescribe la fila de controles en pantallas pequeñas */
        @media (max-width: 767px) {
            div.dt-container>div.row {
                justify-content: center !important;
                /* centra todos los elementos */
                flex-wrap: wrap;
                /* para que se ajusten si hay varios elementos */
            }

            div.dt-container .dataTables_filter {
                text-align: center !important;
                /* centra el input */
                width: 100%;
                /* opcional, que ocupe todo el ancho */
            }
        }
        /* NAVBAR */
    </style>
</head>
<!-- NAVBAR DINAMICO CAMBIA DEPENDIENDO DE QUIEN INICIE SESION -->
<?php
// Verificar sesión de forma segura
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generar CSRF token si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Variables seguras para el navbar
$isLoggedIn = isset($_SESSION['usuario']) &&
    !empty($_SESSION['usuario']) &&
    isset($_SESSION['csrf_token']) &&
    isset($_SESSION['session_id']) &&
    $_SESSION['session_id'] === session_id();

$nombreUsuario = $isLoggedIn ? ($_SESSION['nombre'] ?? 'Usuario') : 'Invitado';
$rolesValidos = ['jefe', 'empleado'];
$rolUsuario = $isLoggedIn && in_array($_SESSION['rol'] ?? '', $rolesValidos) ? $_SESSION['rol'] : null;

// Sanitizar datos de salida
$nombreUsuario = htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8');
$rolUsuario = $rolUsuario ? htmlspecialchars($rolUsuario, ENT_QUOTES, 'UTF-8') : null;

// URLs permitidas por rol (whitelist de seguridad)
$urlsPermitidas = [
    'jefe' => [
        '/dashboard' => 'Dashboard',
        '/empleados' => 'Empleados',
        '/reportes' => 'Reportes',
        '/productos' => 'Productos'
    ],
    'empleado' => [
        '/mis-tareas' => 'Mis Tareas',
        '/productos' => 'Productos',
        '/perfil' => 'Mi Perfil'
    ]
];

$iconos = [
    '/dashboard' => 'bi-speedometer2',
    '/empleados' => 'bi-people',
    '/reportes' => 'bi-graph-up',
    '/productos' => 'bi-box',
    '/mis-tareas' => 'bi-list-task',
    '/perfil' => 'bi-person'
];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Logo a la izquierda -->
        <a class="navbar-brand fw-bold fs-3" href="/" style="color: white !important; text-decoration: none;">
            <i class="bi bi-building me-2"></i>Genesys
        </a>

        <!-- Botón para móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Menú central (según el rol) -->
            <ul class="navbar-nav me-auto">
                <?php if ($isLoggedIn && isset($urlsPermitidas[$rolUsuario])): ?>
                    <?php foreach ($urlsPermitidas[$rolUsuario] as $url => $texto): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="<?php echo htmlspecialchars($iconos[$url] ?? 'bi-circle', ENT_QUOTES, 'UTF-8'); ?> me-1"></i>
                                <?php echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <!-- Menú derecho (Usuario, Asistencia, Login/Logout) -->
            <ul class="navbar-nav">
                <?php if ($isLoggedIn): ?>
                    <!-- Nombre del usuario -->
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            <strong><?php echo $nombreUsuario; ?></strong>
                        </span>
                    </li>

                    <!-- Botón Asistencia -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light me-2" href="/asistencia">
                            <i class="bi bi-clock me-1"></i>Asistencia
                        </a>
                    </li>

                    <!-- Formulario Cerrar Sesión SEGURO -->
                    <li class="nav-item">
                        <form method="POST" action="/logout" style="display: inline;" class="m-0">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="action" value="logout">
                            <button type="submit" class="nav-link btn btn-outline-danger border-0"
                                name="logout_submit">
                                <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                <?php else: ?>
                    <!-- Botón Iniciar Sesión -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary" href="/login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<body>