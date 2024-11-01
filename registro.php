<?php
session_start();
include 'dist/pages/bd.php';

if (isset($_POST['register'])) {
    $username = $_POST['register_username'];
    $password = $_POST['register_password'];
    $imagen = $_POST['imagen'];

    // imagen 
    $file_name = $_FILES['imagen']['name'];
    $file_tmp_path = $_FILES['imagen']['tmp_name'];
    $file_type = $_FILES['imagen']['type'];
    $file_size = $_FILES['imagen']['size'];

    // Aquí se carga la imagen 
    $upload_file_dir = 'dist/assets/img/'; 
    $dest_path = $upload_file_dir . basename($file_name);

    // Mira que archivo se está cargando y da el límite de carga 
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($file_type, $allowed_types) && $file_size < 2000000) { 
        
        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            
            $query = "INSERT INTO usuarios (username, password, imagen) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, password_hash($password, PASSWORD_DEFAULT), $dest_path);

            if ($stmt->execute()) {
                $success_message = "Usuario registrado exitosamente.";
            } else {
                $error_message = "Error al registrar el usuario: " . $stmt->error;
            }
        } else {
            $error_message = "Error al mover la imagen a la carpeta. Verifica permisos.";
        }
    } else {
        $error_message = "Archivo no permitido o demasiado grande.";
    }
}
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
        
        <form action="registro.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="register_username" class="form-label">Nuevo Usuario</label>
                <input type="text" name="register_username" id="register_username" class="form-control" placeholder="Ingrese un nuevo usuario" required>
            </div>
            <div class="mb-3">
                <label for="register_password" class="form-label">Nueva Contraseña</label>
                <input type="password" name="register_password" id="register_password" class="form-control" placeholder="Ingrese una nueva contraseña" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Foto de Usuario</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Registrar</button>
        </form>
        <div class="mt-3">
            <a href="login.php" class="btn btn-link">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
