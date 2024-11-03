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

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                        <h3 class="mb-0">
                        <?php
                                include 'rutas.php'; 

                                $nombre_pagina = 'Panel-de-control';

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

                                $nombre_pagina = 'Panel-de-control';

                                if (array_key_exists($nombre_pagina, $nombre_paginas)) {
                                    echo $nombre_paginas[$nombre_pagina];
                                } else {
                                    echo 'Página no encontrada';
                                }
                                ?>
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Producto mas vendido</h3> <a href="javascript:void(0);" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Ver informe</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column"> <span class="fw-bold fs-5"><?php echo $cantidad_vendida; ?></span> <span>Producto mas vendidio durante la ultima semana</span> </p>
                                        <p class="ms-auto d-flex flex-column text-end"> <span class="text-success"> <i class="bi bi-arrow-up"></i> <?php echo number_format($porcentaje, 2); ?>%
                                            </span> <span class="text-secondary">Desde la semana pasada</span> </p>
                                    </div> <!-- /.d-flex -->
                                    <div class="position-relative mb-4">
                                        <div id="visitors-chart"></div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-end"> <span class="me-2"> <i class="bi bi-square-fill text-primary"></i> Esta semana
                                        </span> <span> <i class="bi bi-square-fill text-secondary"></i> La semana pasada
                                        </span> </div>
                                </div>
                            </div> <!-- /.card -->
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Productos</h3>
                                    <div class="card-tools"> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-download"></i> </a> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a> </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Ventas</th>
                                                <th>Más</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> <img src="../../dist/assets/img/default-150x150.png" alt="Producto 1" class="rounded-circle img-size-32 me-2">
                                                    Producto 1
                                                </td>
                                                <td>Q13 QTZ</td>
                                                <td> <small class="text-success me-1"> <i class="bi bi-arrow-up"></i>
                                                        12%
                                                    </small>
                                                    12,000 Vendidos
                                                </td>
                                                <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                                            </tr>
                                            <tr>
                                                <td> <img src="../../dist/assets/img/default-150x150.png" alt="Producto 1" class="rounded-circle img-size-32 me-2">
                                                    Producto 2
                                                </td>
                                                <td>Q29 QTZ</td>
                                                <td> <small class="text-info me-1"> <i class="bi bi-arrow-down"></i>
                                                        0.5%
                                                    </small>
                                                    123,234 Vendidos
                                                </td>
                                                <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                                            </tr>
                                            <tr>
                                                <td> <img src="../../dist/assets/img/default-150x150.png" alt="Producto 1" class="rounded-circle img-size-32 me-2">
                                                    Producto 3
                                                </td>
                                                <td>Q1,230 QTZ</td>
                                                <td> <small class="text-danger me-1"> <i class="bi bi-arrow-down"></i>
                                                        3%
                                                    </small>
                                                    198 Vendidos
                                                </td>
                                                <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                                            </tr>
                                            <tr>
                                                <td> <img src="../../dist/assets/img/default-150x150.png" alt="Producto 1" class="rounded-circle img-size-32 me-2">
                                                    Producto 4
                                                    <span class="badge text-bg-danger">NUEVO</span>
                                                </td>
                                                <td>Q199 QTZ</td>
                                                <td> <small class="text-success me-1"> <i class="bi bi-arrow-up"></i>
                                                        63%
                                                    </small>
                                                    87 Vendidos
                                                </td>
                                                <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col-md-6 -->
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Sales</h3> <a href="javascript:void(0);" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Ver informe</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <p class="d-flex flex-column"> <span class="fw-bold fs-5">Q<?php echo number_format($total_ventas, 2); ?></span> <span>Ventas totales</span> </p>
                                        <p class="ms-auto d-flex flex-column text-end"> <span class="text-success"> <i class="bi bi-arrow-up"></i> <?php echo number_format($porcentaje_ventas, 1); ?>%
                                            </span> <span class="text-secondary">Desde el año pasado</span> </p>
                                    </div> <!-- /.d-flex -->
                                    <div class="position-relative mb-4">
                                        <div id="sales-chart"></div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-end"> <span class="me-2"> <i class="bi bi-square-fill text-primary"></i> Este año
                                        </span> <span> <i class="bi bi-square-fill text-secondary"></i> El año pasado
                                        </span> </div>
                                </div>
                            </div> <!-- /.card -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Descripción general de la tienda en línea</h3>
                                    <div class="card-tools"> <a href="#" class="btn btn-sm btn-tool"> <i class="bi bi-download"></i> </a> <a href="#" class="btn btn-sm btn-tool"> <i class="bi bi-list"></i> </a> </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-success fs-2"> <svg height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3"></path>
                                            </svg> </p>
                                        <p class="d-flex flex-column text-end"> <span class="fw-bold"> <i class="bi bi-graph-up-arrow text-success"></i> 12%
                                            </span> <span class="text-secondary">TASA DE CONVERSIÓN</span> </p>
                                    </div> <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-info fs-2"> <svg height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                            </svg> </p>
                                        <p class="d-flex flex-column text-end"> <span class="fw-bold"> <i class="bi bi-graph-up-arrow text-info"></i> 0.8%
                                            </span> <span class="text-secondary">TASA DE VENTAS</span> </p>
                                    </div> <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <p class="text-danger fs-2"> <svg height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                            </svg> </p>
                                        <p class="d-flex flex-column text-end"> <span class="fw-bold"> <i class="bi bi-graph-down-arrow text-danger"></i>
                                                1%
                                            </span> <span class="text-secondary">TASA DE INSCRIPCIÓN</span> </p>
                                    </div> <!-- /.d-flex -->
                                </div>
                            </div>
                        </div> <!-- /.col-md-6 -->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
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
    document.addEventListener('DOMContentLoaded', function() {
        const visitors_chart_options = {
            series: [{
                name: "Esta Semana",
                data: [<?php 
                    // Asegúrate de que haya datos y convierte a formato JSON
                    if (!empty($ventas_esta_semana)) {
                        echo implode(',', array_column($ventas_esta_semana, 'total_vendido'));
                    } else {
                        echo '0'; // Valor por defecto si no hay datos
                    }
                ?>],
            },
            {
                name: "Semana Pasada",
                data: [<?php 
                    // Asegúrate de que haya datos y convierte a formato JSON
                    if (!empty($ventas_semana_pasada)) {
                        echo implode(',', array_column($ventas_semana_pasada, 'total_vendido'));
                    } else {
                        echo '0'; // Valor por defecto si no hay datos
                    }
                ?>],
            }],
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
                    colors: ["#f3f3f3", "transparent"],
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
                categories: ["L", "M", "M", "J", "V", "S", "D"],  // Días de la semana
            },
        };

        const visitors_chart = new ApexCharts(
            document.querySelector("#visitors-chart"),
            visitors_chart_options
        );
        visitors_chart.render();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sales_chart_options = {
            series: [{
                name: "Este Año",
                data: <?php echo $current_year_sales_json; ?>,
            },
            {
                name: "Año Pasado",
                data: <?php echo $last_year_sales_json; ?>,
            }],
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
                show: true,
            },
            colors: ["#0d6efd", "#20c997"],
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
                    "Ene", "Feb", "Mar", "Abr", "May", "Jun", 
                    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
                ],
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Q " + val.toFixed(2);
                    },
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#sales-chart"),
            sales_chart_options
        );
        sales_chart.render();
    });
</script>

</body><!--end::Body-->

</html>