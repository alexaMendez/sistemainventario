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
    <title>Iniciar Sesión</title>
    <link rel="icon" href="dist/assets/img/3.png" type="image/x-icon">
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        <img src="dist/assets/img/3.png" alt="Imagen de perfil" class="rounded-circle mb-4" style="width: 100px; height: 100px;">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Ingrese su usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>

        <div class="mt-3">
            <a href="registro.php" class="btn btn-link">Regístrate</a>
            <a href="recuperar_contraseña.php" class="btn btn-link">Recuperar contraseña</a>
        </div>
    </div>
</body>
</html>
