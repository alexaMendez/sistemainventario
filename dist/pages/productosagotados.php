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

$limite = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

$sql = "SELECT * FROM compras WHERE cantidad = 0 LIMIT :inicio, :limite";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) FROM compras WHERE cantidad = 0";
$totalProductos = $pdo->query($sql)->fetchColumn();
$totalPaginas = ceil($totalProductos / $limite);

?>
<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <?php include 'docs/componentes/header.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sistema de inventario | Dashboard</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Admin | Panel de control">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="technologysolution is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(technologysolution)-->
    <link rel="stylesheet" href="../../dist/css/technologysolution.css"><!--end::Required Plugin(technologysolution)--><!-- apexcharts -->
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
    <script>
        function mostrarAlerta(mensaje) {
            if (mensaje) {
                alert(mensaje);
            }
        }
    </script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
<div class="container mt-5">
        <h2>Productos Agotados</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Agotamiento</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($productos): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($producto['fecha_agotamiento']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No hay productos agotados en este momento.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botón de "Ver Siguiente" -->
        <div class="d-flex justify-content-between">
            <?php if ($pagina > 1): ?>
                <a href="productosagotados.php?pagina=<?php echo $pagina - 1; ?>" class="btn btn-primary">Anterior</a>
            <?php endif; ?>

            <?php if ($pagina < $totalPaginas): ?>
                <a href="productosagotados.php?pagina=<?php echo $pagina + 1; ?>" class="btn btn-primary">Ver Siguiente</a>
            <?php endif; ?>
        </div>
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
    </script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        const visitors_chart_options = {
            series: [{
                    name: "High - 2023",
                    data: [100, 120, 170, 167, 180, 177, 160],
                },
                {
                    name: "Low - 2023",
                    data: [60, 80, 70, 67, 80, 77, 100],
                },
            ],
            chart: {
                height: 200,
                type: "line",
                toolbar: {
                    show: false,
                },
            },
            colors: ["#0d6efd", "#adb5bd"],
            stroke: {
                curve: "smooth",
            },
            grid: {
                borderColor: "#e7e7e7",
                row: {
                    colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                    opacity: 0.5,
                },
            },
            legend: {
                show: false,
            },
            markers: {
                size: 1,
            },
            xaxis: {
                categories: ["22th", "23th", "24th", "25th", "26th", "27th", "28th"],
            },
        };

        const visitors_chart = new  ApexCharts(
            document.querySelector("#visitors-chart"),
            visitors_chart_options
        );
        visitors_chart.render();

        const sales_chart_options = {
            series: [{
                    name: "Net Profit",
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
                },
                {
                    name: "Revenue",
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
                },
                {
                    name: "Free Cash Flow",
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
                },
            ],
            chart: {
                type: "bar",
                height: 200,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            legend: {
                show: false,
            },
            colors: ["#0d6efd", "#20c997", "#ffc107"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: [
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                ],
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Q " + val + " thousands";
                    },
                },
            },
        };

        const sales_chart = new  ApexCharts(
            document.querySelector("#sales-chart"),
            sales_chart_options
        );
        sales_chart.render();
    </script> <!--end::Script-->
</body><!--end::Body-->

</html>