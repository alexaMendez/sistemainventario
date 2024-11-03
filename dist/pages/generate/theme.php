<?php
session_start();


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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sistema de inventario  | Personalizar tema</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="technologysolution 4 | Theme Customize">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="technologysolution is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(technologysolution)-->
    <link rel="stylesheet" href="../../../dist/css/technologysolution.css"><!--end::Required Plugin(technologysolution)-->
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
    <?php include '../header.php'; ?>
</head> <!--end::Head--> <!--begin::Body-->


<body class="sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->

        <aside class="app-sidebar bg-primary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="../index.html" class="brand-link"> <!--begin::Brand Image--> <img src="../../../dist/assets/img/technologysolutionLogo.png" alt="technologysolution Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-light">Technology Solution</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Level 1</p>
                            </a> </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>
                                    Level 1
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Level 2</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>
                                            Level 2
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                    </ul>
                                </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Level 2</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Level 1</p>
                            </a> </li>
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                        <div class="col-sm-6">
                            <h3 class="mb-0">Theme Customize</h3>
                        </div> <!--end::Col--> <!--begin::Col-->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Theme Customize
                                </li>
                            </ol>
                        </div> <!--end::Col-->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                        <div class="col-12"> <!--begin::Card-->
                            <div class="card"> <!--begin::Card Header-->
                                <div class="card-header"> <!--begin::Card Title-->
                                    <h3 class="card-title">Sidebar Theme</h3> <!--end::Card Title--> <!--begin::Card Toolbar-->
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove"> <i class="bi bi-x-lg"></i> </button> </div> <!--end::Card Toolbar-->
                                </div> <!--end::Card Header--> <!--begin::Card Body-->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row"> <!--begin::Col-->
                                        <div class="col-md-3"> <select id="sidebar-color-modes" class="form-select form-select-lg" aria-label="Sidebar Color Mode Select">
                                                <option value="">---Select---</option>
                                                <option value="dark">Dark</option>
                                                <option value="light">Light</option>
                                            </select> </div> <!--end::Col--> <!--begin::Col-->
                                        <div class="col-md-3"> <select id="sidebar-color" class="form-select form-select-lg" aria-label="Sidebar Color Select">
                                                <option value="">---Select---</option>
                                            </select> </div> <!--end::Col--> <!--begin::Col-->
                                        <div class="col-md-6">
                                            <div id="sidebar-color-code" class="w-100"></div>
                                        </div> <!--end::Col-->
                                    </div> <!--end::Row-->
                                </div> <!--end::Card Body--> <!--begin::Card Footer-->
                                <div class="card-footer">
                                    Check more color in
                                    <a href="https://getbootstrap.com/docs/5.3/utilities/background/" target="_blank" class="link-primary">Bootstrap Background Colors</a>
                                </div> <!--end::Card Footer-->
                            </div> <!--end::Card--> <!--begin::Card-->
                            <div class="card mt-4"> <!--begin::Card Header-->
                                <div class="card-header"> <!--begin::Card Title-->
                                    <h3 class="card-title">Navbar Theme</h3> <!--end::Card Title--> <!--begin::Card Toolbar-->
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove"> <i class="bi bi-x-lg"></i> </button> </div> <!--end::Card Toolbar-->
                                </div> <!--end::Card Header--> <!--begin::Card Body-->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row"> <!--begin::Col-->
                                        <div class="col-md-3"> <select id="navbar-color-modes" class="form-select form-select-lg" aria-label="Navbar Color Mode Select">
                                                <option value="">---Select---</option>
                                                <option value="dark">Dark</option>
                                                <option value="light">Light</option>
                                            </select> </div> <!--end::Col--> <!--begin::Col-->
                                        <div class="col-md-3"> <select id="navbar-color" class="form-select form-select-lg" aria-label="Navbar Color Select">
                                                <option value="">---Select---</option>
                                            </select> </div> <!--end::Col--> <!--begin::Col-->
                                        <div class="col-md-6">
                                            <div id="navbar-color-code" class="w-100"></div>
                                        </div> <!--end::Col-->
                                    </div> <!--end::Row-->
                                </div> <!--end::Card Body--> <!--begin::Card Footer-->
                                <div class="card-footer">
                                    Check more color in
                                    <a href="https://getbootstrap.com/docs/5.3/utilities/background/" target="_blank" class="link-primary">Bootstrap Background Colors</a>
                                </div> <!--end::Card Footer-->
                            </div> <!--end::Card-->
                        </div> <!--end::Col-->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
        <footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://technologysolution.io" class="text-decoration-none">technologysolution.io</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(technologysolution)-->
    <script src="../../../dist/js/technologysolution.js"></script> <!--end::Required Plugin(technologysolution)--><!--begin::OverlayScrollbars Configure-->
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
    </script> <!--end::OverlayScrollbars Configure-->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const appSidebar = document.querySelector(".app-sidebar");
            const sidebarColorModes = document.querySelector(
                "#sidebar-color-modes",
            );
            const sidebarColor = document.querySelector("#sidebar-color");
            const sidebarColorCode = document.querySelector("#sidebar-color-code");

            const themeBg = [
                "bg-primary",
                "bg-primary-subtle",
                "bg-secondary",
                "bg-secondary-subtle",
                "bg-success",
                "bg-success-subtle",
                "bg-danger",
                "bg-danger-subtle",
                "bg-warning",
                "bg-warning-subtle",
                "bg-info",
                "bg-info-subtle",
                "bg-light",
                "bg-light-subtle",
                "bg-dark",
                "bg-dark-subtle",
                "bg-body-secondary",
                "bg-body-tertiary",
                "bg-body",
                "bg-black",
                "bg-white",
                "bg-transparent",
            ];

            // loop through each option themeBg array
            document.querySelector("#sidebar-color").innerHTML = themeBg.map(
                (bg) => {
                    // return option element with value and text
                    return `<option value="${bg}" class="text-${bg}">${bg}</option>`;
                },
            );

            let sidebarColorMode = "";
            let sidebarBg = "";

            function updateSidebar() {
                appSidebar.setAttribute("data-bs-theme", sidebarColorMode);

                sidebarColorCode.innerHTML = `<pre><code class="language-html">&lt;aside class="app-sidebar ${sidebarBg}" data-bs-theme="${sidebarColorMode}"&gt;...&lt;/aside&gt;</code></pre>`;
            }

            sidebarColorModes.addEventListener("input", (event) => {
                sidebarColorMode = event.target.value;
                updateSidebar();
            });

            sidebarColor.addEventListener("input", (event) => {
                sidebarBg = event.target.value;

                themeBg.forEach((className) => {
                    appSidebar.classList.remove(className);
                });

                if (themeBg.includes(sidebarBg)) {
                    appSidebar.classList.add(sidebarBg);
                }

                updateSidebar();
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const appNavbar = document.querySelector(".app-header");
            const navbarColorModes = document.querySelector("#navbar-color-modes");
            const navbarColor = document.querySelector("#navbar-color");
            const navbarColorCode = document.querySelector("#navbar-color-code");

            const themeBg = [
                "bg-primary",
                "bg-primary-subtle",
                "bg-secondary",
                "bg-secondary-subtle",
                "bg-success",
                "bg-success-subtle",
                "bg-danger",
                "bg-danger-subtle",
                "bg-warning",
                "bg-warning-subtle",
                "bg-info",
                "bg-info-subtle",
                "bg-light",
                "bg-light-subtle",
                "bg-dark",
                "bg-dark-subtle",
                "bg-body-secondary",
                "bg-body-tertiary",
                "bg-body",
                "bg-black",
                "bg-white",
                "bg-transparent",
            ];

            // loop through each option themeBg array
            document.querySelector("#navbar-color").innerHTML = themeBg.map(
                (bg) => {
                    // return option element with value and text
                    return `<option value="${bg}" class="text-${bg}">${bg}</option>`;
                },
            );

            let navbarColorMode = "";
            let navbarBg = "";

            function updateNavbar() {
                appNavbar.setAttribute("data-bs-theme", navbarColorMode);
                navbarColorCode.innerHTML = `<pre><code class="language-html">&lt;nav class="app-header navbar navbar-expand ${navbarBg}" data-bs-theme="${navbarColorMode}"&gt;...&lt;/nav&gt;</code></pre>`;
            }

            navbarColorModes.addEventListener("input", (event) => {
                navbarColorMode = event.target.value;
                updateNavbar();
            });

            navbarColor.addEventListener("input", (event) => {
                navbarBg = event.target.value;

                themeBg.forEach((className) => {
                    appNavbar.classList.remove(className);
                });

                if (themeBg.includes(navbarBg)) {
                    appNavbar.classList.add(navbarBg);
                }

                updateNavbar();
            });
        });
    </script> <!--end::Script-->
</body><!--end::Body-->

</html>