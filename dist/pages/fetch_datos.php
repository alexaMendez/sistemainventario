<?php
include 'bd.php';

// Verificar si nofactura está definido y tiene un valor válido
$nofactura = isset($_GET['nofactura']) ? $_GET['nofactura'] : null;

if ($nofactura) {
    // Preparar y ejecutar la consulta para obtener productos y proveedores
    $stmt = $pdo->prepare("SELECT nombreproducto, nombreproveedor FROM compras WHERE nofactura = :nofactura");
    $stmt->bindParam(':nofactura', $nofactura, PDO::PARAM_INT); // Asegura que nofactura sea un número entero
    $stmt->execute();

    $productos = [];
    $proveedores = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $row['nombreproducto'];
        $proveedores[] = $row['nombreproveedor'];
    }

    // Responder con los datos JSON
    header('Content-Type: application/json');
    echo json_encode(['productos' => $productos, 'proveedores' => $proveedores]);
} else {
    // Si no hay un número de factura válido, devolver un mensaje de error en JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No se proporcionó un número de factura válido.']);
}
exit();
