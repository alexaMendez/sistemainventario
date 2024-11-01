<?php
session_start();
include 'dist/pages/bd.php'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Registro</title>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Registro</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="register_username" class="form-label">Nuevo Usuario</label>
                <input type="text" name="register_username" id="register_username" class="form-control" placeholder="Ingrese un nuevo usuario" required>
            </div>
            <div class="mb-3">
                <label for="register_password" class="form-label">Nueva Contraseña</label>
                <input type="password" name="register_password" id="register_password" class="form-control" placeholder="Ingrese una nueva contraseña" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Registrar</button>
        </form>
        <div class="mt-3">
            <a href="login.php" class="btn btn-link">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
