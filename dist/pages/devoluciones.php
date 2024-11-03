<?php
session_start();
include 'bd.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: /sistemainventario/login.php"); 
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
    session_unset(); 
    session_destroy(); 
    header("Location: /sistemainventario/login.php"); 
    exit();
}

$_SESSION['last_activity'] = time(); 

// Parte del código que sirve para el ingreso de datos 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreproducto = $_POST['nombreproducto'];
    $nofactura = $_POST['nofactura'];
    $nombreproveedor = $_POST['nombreproveedor'];
    $total = $_POST['total'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $razondevolucion = $_POST['razondevolucion'];
    $tipo = $_POST['tipo'];

    if (!empty($nombreproducto) && !empty($razondevolucion) && !empty($tipo) && is_numeric($nofactura) && !empty($nombreproveedor) && is_numeric($total) && is_numeric($cantidad) && is_numeric($precio) && !empty($fecha)) {

        // Verificar si el producto ya existe
        $sql = "SELECT nofactura, nombreproducto, nombreproveedor, cantidad, total FROM compras WHERE nofactura = :nofactura AND nombreproducto = :nombreproducto AND nombreproveedor = :nombreproveedor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nofactura', $nofactura);
        $stmt->bindParam(':nombreproducto', $nombreproducto);
        $stmt->bindParam(':nombreproveedor', $nombreproveedor);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si el producto existe, actualizar restando valores
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nueva_cantidad = $row['cantidad'] - $cantidad;
            $nuevo_total = $row['total'] - $total;

            // Verificar si la nueva cantidad es válida
            if ($nueva_cantidad < 0) {
                echo '<script>
                        alert("No hay suficientes productos disponibles para devolver.");
                    </script>';
            } else {
                $sql_update = "UPDATE compras 
                                SET cantidad = :nueva_cantidad, 
                                    total = :nuevo_total,
                                    tipo = :tipo, 
                                    fecha = :fecha,
                                    razondevolucion = :razondevolucion
                                WHERE nofactura = :nofactura 
                                AND nombreproducto = :nombreproducto 
                                AND nombreproveedor = :nombreproveedor";
                $stmt_update = $pdo->prepare($sql_update);

                $stmt_update->bindParam(':nueva_cantidad', $nueva_cantidad);
                $stmt_update->bindParam(':nuevo_total', $nuevo_total);
                $stmt_update->bindParam(':tipo', $tipo);
                $stmt_update->bindParam(':fecha', $fecha);
                $stmt_update->bindParam(':razondevolucion', $razondevolucion);
                $stmt_update->bindParam(':nofactura', $nofactura);
                $stmt_update->bindParam(':nombreproducto', $nombreproducto);
                $stmt_update->bindParam(':nombreproveedor', $nombreproveedor);

                if ($stmt_update->execute()) {
                    echo '<script>
                            alert("Producto actualizado exitosamente.");
                        </script>';
                } else {
                    echo '<script>
                            alert("Error al actualizar el producto.");
                        </script>';
                }
            }
        } else {
            // Si el producto no existe, muestra mensaje pero no inserta nada
            echo '<script>
                    alert("Producto no encontrado.");
                </script>';
        }
    } else {
        echo '<script>
                alert("Por favor, completa todos los campos correctamente.");
            </script>';
    }
}

$query = "SELECT DISTINCT nofactura, nombreproducto, nombreproveedor FROM compras";
$resul_datos = $pdo->query($query);

$productos = [];
$nofacturas = [];
$proveedores = [];

foreach ($resul_datos as $row) {
    // Crear arrays únicos para cada categoría basada en la consulta
    if (!in_array($row['nombreproducto'], $productos)) {
        $productos[] = $row['nombreproducto'];
    }
    if (!in_array($row['nofactura'], $nofacturas)) {
        $nofacturas[] = $row['nofactura'];
    }
    if (!in_array($row['nombreproveedor'], $proveedores)) {
        $proveedores[] = $row['nombreproveedor'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'docs/componentes/header.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sistema de inventario | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Admin | Panel de control">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="technologysolution is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <link rel="stylesheet" href="../../dist/css/technologysolution.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">

    <script>
        let timeout; 

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logout, 600000); 
        }

        function logout() {
            window.location.href = 'logout.php';
        }

        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;
    </script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">
                                <?php
                                include 'rutas.php'; 

                                $nombre_pagina = 'Devoluciones';

                                if (array_key_exists($nombre_pagina, $nombre_paginas)) {
                                    echo $nombre_paginas[$nombre_pagina];
                                } else {
                                    echo 'Página no encontrada';
                                }
                                ?>
                            </h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php
                                    include 'rutas.php'; 

                                    $nombre_pagina = 'Devoluciones';

                                    if (array_key_exists($nombre_pagina, $nombre_paginas)) {
                                        echo $nombre_paginas[$nombre_pagina];
                                    } else {
                                        echo 'Página no encontrada';
                                    }
                                    ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <form method="POST" action="devoluciones.php">
                            <table class="table table-bordered">
                                <tr>
                                <td><label for="tipo">Tipo de Gestion</label></td>
                                <td><input type="text" id="tipo" name="tipo" class="form-control" value="Devolucion" readonly></td>
                                <td><label for="fecha">Fecha</label></td>
                                <td><input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" ></td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <tr>
                                    <td><label for="nofactura">No. Factura</label></td>
                                    <td>
                                    <select name="nofactura" id="nofactura" class="form-control">
                                        <?php foreach ($nofacturas as $factura): ?>
                                            <option value="<?php echo $factura; ?>"><?php echo $factura; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                    </td>
                                    <td><label for="nombreproducto">Nombre Producto</label></td>
                                    <td>
                                    <select name="nombreproducto" id="nombreproducto" class="form-control">
                                    <?php foreach ($productos as $producto): ?>
                                        <option value="<?php echo $producto; ?>"><?php echo $producto; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="nombreproveedor">Nombre Proveedor</label></td>
                                    <td>
                                    <select name="nombreproveedor" id="nombreproveedor" class="form-control">
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?php echo $proveedor; ?>"><?php echo $proveedor; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </td>
                                    <td><label for="cantidad">Cantidad</label></td>
                                    <td>
                                    <input type="number" id="cantidad" name="cantidad" class="form-control" required oninput="calculartotal()">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="precio">Precio Unitario</label></td>
                                    <td><input type="number" id="precio" name="precio" step="0.01" class="form-control" required oninput="calculartotal()"></td>
                                    <td><label for="total">Total devolucion</label></td>
                                    <td><input type="number" id="total" name="total" step="0.01" class="form-control" readonly></td>
                                    <td>
                                    <script>
                                        function calculartotal() {
                                            var cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
                                            var precio = parseFloat(document.getElementById('precio').value) || 0;
                                            var total = cantidad * precio;
                                            document.getElementById('total').value = total.toFixed(2);
                                        }
                                    </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="razondevolucion">Razon de la devolucion</label></td>
                                    <td colspan="3" class="text-center"><input type="text" id="razondevolucion" name="razondevolucion" step="0.01" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                    <button type="submit" class="btn btn-primary mt-3">Generar Devolucion</button>
                                    </td>
                                </tr>
                            </table>
                            <script>
                                function calculartotal() {
                                    var cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
                                    var precio = parseFloat(document.getElementById('precio').value) || 0;
                                    var total = cantidad * precio;
                                    document.getElementById('total').value = total.toFixed(2);
                                }

                                function updateAvailableQuantity() {
                                    
                                }

                                function validateQuantity() {
                                    var cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
                                    var producto = document.getElementById('nombreproducto').value;
                                    var availableQuantity = 0; 

                                    if (cantidad > availableQuantity) {
                                        alert('No hay suficientes productos disponibles para devolver. Cantidad disponible: ' + availableQuantity);
                                        return false; 
                                    }
                                    return true; 
                                }
                            </script>
                        </form>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
        <footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Sistemas Operativos</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy; 2024-2024&nbsp;
                <a href="https://technologysolutions.ar502.com/" class="text-decoration-none">technologysolutions</a>.
            </strong>
            Todos los derechos reservados.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(technologysolution)-->
    <script src="../../dist/js/technologysolution.js"></script> <!--end::Required Plugin(technologysolution)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> 
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    
</body>
</html>