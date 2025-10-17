<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
<div class="container-fluid vh-100">
    <div class="row h-100 justify-content-center align-items-center bg-primary bg-gradient">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4 col-xl-3">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <!-- Logo y título del sistema -->
                    <div class="text-center mb-4">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 60px; height: 60px;">
                            <i class="bi bi-building text-white fs-2"></i>
                        </div>
                        <h2 class="card-title text-primary fw-bold mb-1">Genesys</h2>
                        <p class="text-muted small">Sistema de Gestión</p>
                    </div>

                    <!-- Mensajes de error/éxito -->
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario de login -->
                    <form id="loginForm" action="/sistema_gestion_php-main/controllers/login_controller.php" method="POST">
                        <!-- Campo Usuario -->
                        <div class="mb-3">
                            <label for="usuario" class="form-label">
                                <i class="bi bi-person-fill me-1"></i>Usuario
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   name="usuario" 
                                   id="usuario"
                                   placeholder="Ingresa tu usuario" 
                                   required 
                                   autocomplete="username"
                                   value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       name="password" 
                                       id="password"
                                       placeholder="Ingresa tu contraseña" 
                                       required 
                                       autocomplete="current-password">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        id="togglePassword">
                                    <i class="bi bi-eye-fill" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Recordar sesión y Olvidé contraseña -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="recordar" 
                                       id="recordar" 
                                       value="1">
                                <label class="form-check-label small" for="recordar">
                                    Recordar sesión
                                </label>
                            </div>
                            <a href="forgot_password.view.php" class="text-decoration-none small text-muted">
    ¿Olvidaste tu contraseña?
</a>

                            </a>
                        </div>

                        <!-- Botón de login -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="loginSpinner"></span>
                                <i class="bi bi-box-arrow-in-right me-2" id="loginIcon"></i>
                                Iniciar Sesión
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
    <a href="registro.view.php" class="text-decoration-none">
        ¿No tienes cuenta? Regístrate aquí
    </a>
</div>


                        <!-- Token CSRF si lo usas -->
                        <?php if (isset($_SESSION['csrf_token'])): ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <?php endif; ?>
                    </form>

                    <!-- Footer del formulario -->
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Acceso seguro al sistema
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para recuperar contraseña -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">
                    <i class="bi bi-key me-2"></i>Recuperar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm" action="controllers/forgot_password_controller.php" method="POST">
                    <div class="mb-3">
                        <label for="email_recuperacion" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control" 
                               id="email_recuperacion" 
                               name="email" 
                               placeholder="Ingresa tu correo electrónico" 
                               required>
                        <div class="form-text">Te enviaremos un enlace para restablecer tu contraseña.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="forgotPasswordForm" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Enviar Enlace
                </button>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/layouts/footer.php' ?>