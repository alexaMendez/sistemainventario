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
    <title>Recuperar Contraseña</title>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Recuperar Contraseña</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese su correo electrónico" required>
            </div>
            <button type="submit" name="recover" class="btn btn-warning w-100">Recuperar Contraseña</button>
        </form>
        <div class="mt-3">
            <a href="login.php" class="btn btn-link">Regresar a Iniciar Sesión</a>
        </div>
    </div>
</body>
</html>
