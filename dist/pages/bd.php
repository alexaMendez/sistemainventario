<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "sistema_login"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['last_activity'] = time();
            header("Location: ./dist/pages/index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}

// registro de usuario
if (isset($_POST['register'])) {
    $username = $_POST['register_username'];
    $password = $_POST['register_password'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hash);

    if ($stmt->execute()) {
        $success_message = "Usuario registrado con éxito.";
    } else {
        $error_message = "Error al registrar el usuario.";
    }
}

//recuperación de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recover'])) {
    $email = $_POST['email'];

    $success_message = "Se ha enviado un correo de recuperación a $email.";
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Función para obtener compras dentro de un rango de fechas
function obtenerCompras($pdo, $fechaInicio, $fechaFin) {
    $sql = "SELECT * FROM compras WHERE fecha BETWEEN :fechaInicio AND :fechaFin ORDER BY fecha DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener el mes actual por defecto
$fechaInicioMes = date("Y-m-01");
$fechaFinMes = date("Y-m-t");

$fechaInicio = $_POST['fecha_inicio'] ?? $fechaInicioMes;
$fechaFin = $_POST['fecha_fin'] ?? $fechaFinMes;

$compras = obtenerCompras($pdo, $fechaInicio, $fechaFin);

// Ventas de esta semana
$ventas_esta_semana = [];
$ventas_semana_pasada = [];

$sql = "
    SELECT nombreproducto, SUM(cantidad) AS total_vendido
    FROM compras
    WHERE fecha >= NOW() - INTERVAL 7 DAY
    GROUP BY nombreproducto
    ORDER BY total_vendido DESC
    LIMIT 1";

$resultado = $conn->query($sql);
if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $cantidad_vendida = $fila['total_vendido'];
    $nombreproducto_mas_vendido = $fila['nombreproducto'];
    $ventas_esta_semana[] = ['nombreproducto' => $nombreproducto_mas_vendido, 'total_vendido' => $cantidad_vendida];
} else {
    $cantidad_vendida = 0; 
}

// Ventas de la semana pasada
$sql_last_week = "
    SELECT nombreproducto, SUM(cantidad) AS total_vendido
    FROM compras
    WHERE fecha >= NOW() - INTERVAL 14 DAY AND fecha < NOW() - INTERVAL 7 DAY
    GROUP BY nombreproducto
    ORDER BY total_vendido DESC
    LIMIT 1";
$result_last_week = $conn->query($sql_last_week);
if ($result_last_week && $result_last_week->num_rows > 0) {
    $last_week_data = $result_last_week->fetch_assoc();
    $last_week_sales = $last_week_data['total_vendido'];
    $nombreproducto_semana_pasada = $last_week_data['nombreproducto'];
    $ventas_semana_pasada[] = ['nombreproducto' => $nombreproducto_semana_pasada, 'total_vendido' => $last_week_sales];
} else {
    $last_week_sales = 0;
}

// Convierte las ventas en JSON si es necesario
$ventas_esta_semana_json = json_encode($ventas_esta_semana);
$ventas_semana_pasada_json = json_encode($ventas_semana_pasada);

//porcentaje de ventas 
$sql_total = "SELECT SUM(cantidad) AS total_general
            FROM compras
            WHERE fecha >= NOW() - INTERVAL 7 DAY";

$resultado_total = $conn->query($sql_total);
$total_general = 0;

if ($resultado_total && $resultado_total->num_rows > 0) {
    $fila_total = $resultado_total->fetch_assoc();
    $total_general = $fila_total['total_general'];
}

$porcentaje = $total_general > 0 ? ($cantidad_vendida / $total_general) * 100 : 0;

// Suma total de ventas
$sql_total_ventas = "
    SELECT SUM(precio * cantidad) AS total_ventas
    FROM compras
    WHERE fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
$result_total_ventas = $conn->query($sql_total_ventas);
$total_ventas = $result_total_ventas->fetch_assoc();
$total_ventas = $total_ventas['total_ventas'] ? $total_ventas['total_ventas'] : 0;

// Suma total de ventas del año 
$sql_total_ventas = "
    SELECT SUM(cantidad * precio) AS total_ventas
    FROM compras
    WHERE fecha >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
$result_total_ventas = $conn->query($sql_total_ventas);
$total_ventas = $result_total_ventas->fetch_assoc()['total_ventas'] ?? 0;

// Total de ventas del año pasado
$sql_total_ventas_anio_pasado = "
    SELECT SUM(cantidad * precio) AS total_ventas_anio_pasado
    FROM compras
    WHERE fecha >= DATE_SUB(NOW(), INTERVAL 2 YEAR) AND fecha < DATE_SUB(NOW(), INTERVAL 1 YEAR)";
$result_total_ventas_anio_pasado = $conn->query($sql_total_ventas_anio_pasado);
$total_ventas_anio_pasado = $result_total_ventas_anio_pasado->fetch_assoc()['total_ventas_anio_pasado'] ?? 0;

// Calculo del porcentaje
$porcentaje_ventas = $total_ventas_anio_pasado > 0 
    ? (($total_ventas - $total_ventas_anio_pasado) / $total_ventas_anio_pasado) * 100 
    : 0;

    // Ventas mensuales del año actual
$current_year_sales = array_fill(0, 12, 0); // Inicializa con ceros para cada mes
$sql_current_year = "
    SELECT MONTH(fecha) AS mes, SUM(cantidad * precio) AS total_ventas
    FROM compras
    WHERE YEAR(fecha) = YEAR(NOW())
    GROUP BY mes
    ORDER BY mes";
$result_current_year = $conn->query($sql_current_year);
while ($row = $result_current_year->fetch_assoc()) {
    $current_year_sales[$row['mes'] - 1] = (float)$row['total_ventas'];
}

// Ventas mensuales del año pasado
$last_year_sales = array_fill(0, 12, 0); // Inicializa con ceros para cada mes
$sql_last_year = "
    SELECT MONTH(fecha) AS mes, SUM(cantidad * precio) AS total_ventas
    FROM compras
    WHERE YEAR(fecha) = YEAR(NOW()) - 1
    GROUP BY mes
    ORDER BY mes";
$result_last_year = $conn->query($sql_last_year);
while ($row = $result_last_year->fetch_assoc()) {
    $last_year_sales[$row['mes'] - 1] = (float)$row['total_ventas'];
}

// Convertir a JSON
$current_year_sales_json = json_encode($current_year_sales);
$last_year_sales_json = json_encode($last_year_sales);

//total vendido 
$primerDiaMes = date("Y-m-01");
$ultimoDiaMes = date("Y-m-t");
$sql = "SELECT SUM(totalventa) AS total_ventas_mes FROM ventas WHERE fechaventa BETWEEN '$primerDiaMes' AND '$ultimoDiaMes'";
$resultado = $conn->query($sql);

$totalVentasMes = 0;
if ($resultado && $fila = $resultado->fetch_assoc()) {
    $totalVentasMes = $fila['total_ventas_mes'] ?? 0;
}

$conn->close();

?>
