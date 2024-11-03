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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreproducto = $_POST['nombreproducto'];
    $nofactura = $_POST['nofactura'];
    $nombreproveedor = $_POST['nombreproveedor'];
    $total = $_POST['total'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];

    if (!empty($nombreproducto) && is_numeric($nofactura) && !empty($nombreproveedor) && is_numeric($total) && is_numeric($cantidad) && is_numeric($precio) && !empty($fecha)) {
        $sql = "INSERT INTO compras (nombreproducto, nofactura, nombreproveedor, total, cantidad, precio, fecha) VALUES (:nombreproducto, :nofactura, :nombreproveedor, :total, :cantidad, :precio, :fecha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreproducto', $nombreproducto);
        $stmt->bindParam(':nofactura', $nofactura);
        $stmt->bindParam(':nombreproveedor', $nombreproveedor);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':fecha', $fecha);

        if ($stmt->execute()) {
            echo '<script>
                    function showError() {
                    alert("Compra agregada exitosamente.");
                    }
                    </script>
                    <script>
                    showError();
                </script>';
        } else {
            echo '<script>
                    function showError() {
                    alert("Error al agregar la compra. Por favor, intenta de nuevo.");
                    }
                    </script>
                    <script>
                    showError();
                    </script>';
        }
    } else {
        echo '<script>
                function showError() {
                alert("Por favor, completa todos los campos correctamente.");
                }
                </script>
                <script>
                showError();
                </script>';
    }
}

$query = "SELECT nombreproveedor FROM proveedores";
$resul_proveedores = $pdo->query($query);

$query = "SELECT nombreproducto FROM producto";
$resul_productos = $pdo->query($query);
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

                                $nombre_pagina = 'Agregar-Nueva-Compra';

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

                                    $nombre_pagina = 'Agregar-Nueva-Compra';

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
                        <form method="POST" action="agregarcompra.php">
                            <div class="form-group">
                                <label for="nombreproveedor">Nombre del proveedor</label>
                                <select name="nombreproveedor" id="nombreproveedor" class="form-control" required>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php while ($row = $resul_proveedores->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo htmlspecialchars($row['nombreproveedor']); ?>">
                                            <?php echo htmlspecialchars($row['nombreproveedor']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nofactura">Número de Factura</label>
                                <input type="number" id="nofactura" name="nofactura" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" >
                            </div>
                            <div class="form-group">
                                <label for="nombreproducto">producto</label>
                                <select name="nombreproducto" id="nombreproducto" class="form-control" required>
                                    <option value="">Selecciona un producto</option>
                                    <?php while ($row = $resul_productos->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?php echo htmlspecialchars($row['nombreproducto']); ?>">
                                            <?php echo htmlspecialchars($row['nombreproducto']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" required oninput="calculartotal()">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio Unitario</label>
                                <input type="number" id="precio" name="precio" step="0.01" class="form-control" required oninput="calculartotal()">
                            </div>
                            <div class="form-group">
                                <label for="total">Precio Total</label>
                                <input type="number" id="total" name="total" step="0.01" class="form-control" readonly>
                            </div>
                            <script>
                                function calculartotal() {
                                    var cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
                                    var precio = parseFloat(document.getElementById('precio').value) || 0;
                                    var total = cantidad * precio;
                                    document.getElementById('total').value = total.toFixed(2);
                                }
                            </script>
                            <button type="submit" class="btn btn-primary mt-3">Agregar Compra</button>
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