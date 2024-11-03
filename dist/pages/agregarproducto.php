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
    $cantidad = $_POST['cantidad'];
    $fecha_registro = $_POST['fecha_registro'];
    $categoriaproducto = $_POST['categoriaproducto'];

    if (!empty($nombreproducto) && is_numeric($cantidad) && !empty($fecha_registro) && !empty($categoriaproducto)) {

        // Verificar si el producto ya existe
        $sql = "SELECT cantidad FROM producto WHERE nombreproducto = :nombreproducto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombreproducto', $nombreproducto);
        $stmt->execute();
        
        
        
if ($stmt->rowCount() > 0) {
            // Si el producto existe, actualizar sus valores
$row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nueva_cantidad = $row['cantidad'] + $cantidad;
            
//$nuevo_total = $row['total'] + $total;

$sql_update = "UPDATE producto 
                            SET cantidad = :nueva_cantidad, 
                                fecha_registro = :fecha_registro,
                                categoriaproducto = :categoriaproducto
                            WHERE nombreproducto = :nombreproducto";
            $stmt_update = $pdo->prepare($sql_update);

            $stmt_update->bindParam(':nueva_cantidad', $nueva_cantidad);
            $stmt_update->bindParam(':fecha_registro', $fecha_registro);
            $stmt_update->bindParam(':nombreproducto', $nombreproducto);
            $stmt_update->bindParam(':categoriaproducto', $categoriaproducto);

            if ($stmt_update->execute()) {
                echo '<script>
                        function showError() {
                        alert("Producto actualizado exitosamente.");
                        }
                        </script>
                        <script>
                        showError();
                        </script>';
            } else {
                
echo '<script>
    function showError() {
    alert("Error al actualizar el producto.");
    }
    </script>
    <script>
    showError();
    </script>';
            }
        } else {
            // Si el producto no existe, insertar uno nuevo
            $sql_insert = "INSERT INTO producto (nombreproducto, cantidad, fecha_registro, categoriaproducto) 
                            VALUES (:nombreproducto, :cantidad, :fecha_registro, :categoriaproducto)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':nombreproducto', $nombreproducto);
            $stmt_insert->bindParam(':cantidad', $cantidad);
            $stmt_insert->bindParam(':fecha_registro', $fecha_registro);
            $stmt_insert->bindParam(':categoriaproducto', $categoriaproducto);

            if ($stmt_insert->execute()) {
                echo '<script>
                        function showError() {
                        alert("Producto agregado exitosamente.");
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

$query = "SELECT categoriaproducto FROM categoriaproducto";
$resul_categoriaproducto = $pdo->query($query);

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
    <link rel="icon" href="dist/assets/img/3.png" type="image/x-icon">
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

                                $nombre_pagina = 'Agregar-Producto';

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

                                    $nombre_pagina = 'Agregar-Producto';

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
                        <form method="POST" action="agregarproducto.php">
                            <table class="table table-bordered">
                                <tr>
                                    <td><label for="fecha_registro">Fecha</label></td>
                                    <td><input type="date" id="fecha_registro" name="fecha_registro" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly></td>
                                    <td><label for="categoriaproducto">Categoria</label></td>
                                    <td>
                                    <select name="categoriaproducto" id="categoriaproducto" class="form-control" required>
                                            <option value="">Selecciona una categoria</option>
                                            <?php while ($row = $resul_categoriaproducto->fetch(PDO::FETCH_ASSOC)): ?>
                                                <option value="<?php echo htmlspecialchars($row['categoriaproducto']); ?>">
                                                    <?php echo htmlspecialchars($row['categoriaproducto']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <tr>
                                    <td><label for="nombreproducto">Nombre del producto</label></td>
                                    <td><input type="text" id="nombreproducto" name="nombreproducto" class="form-control" required oninput="this.value = this.value.toLowerCase();"></td>
                                    <td><label for="cantidad">Cantidad</label></td>
                                    <td><input type="number" id="cantidad" name="cantidad" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                    <button type="submit" class="btn btn-primary mt-3">Agregar Producto</button>
                                    </td>
                                </tr>
                            </table>                    
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