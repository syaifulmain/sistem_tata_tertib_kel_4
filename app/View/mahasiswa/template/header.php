<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $model['title']?></title>
    <link rel="stylesheet" href="<?php echo APP_URL?>/assets/css/bootstrap-edit.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
          integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

<!--    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <style>
        body {
            background-color: #f9fafb;
        }

        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            /*padding: 58px 0 0; !* Height of navbar *!*/
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                padding-top: 58px;
                padding-bottom: 15px;
                position: relative;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-primary">
        <div class="position-sticky  mx-3">
            <a
                class="navbar-brand d-none d-lg-block align-content-center text-white"
                style="height: 58px"
                href="#"
            >
                <img
                    src="<?php echo APP_URL?>/assets/image/Logo.svg"
                    alt=""
                    height="30"
                >
            </a>
            <div class="list-group list-group-flush mt-4 gap-3 " id="navMenu">
                <a
                    href="<?php echo APP_URL?>/mahasiswa/home"
                    class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                    aria-current="true"
                    onclick="setActive(this)"
                >
                    <i class="bi bi-house me-3"></i>
                    <span>Dashboard</span>
                </a>
                <a
                    href="<?php echo APP_URL?>/mahasiswa/pelanggaran"
                    class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                    onclick="setActive(this)"
                >
                    <i class="bi bi-backpack me-3"></i>
                    <span>Pelanggaran</span>
                </a>
                <a
                    href="<?php echo APP_URL?>/mahasiswa/tatatertib"
                    class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                    onclick="setActive(this)"
                >
                    <i class="bi bi-duffle me-3"></i>
                    <span>Tata Tertib</span>
                </a>
            </div>
        </div>
    </nav>
    <div class="d-lg-none"></div>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
<!--                <img-->
<!--                    src="#"-->
<!--                    height="25"-->
<!--                    alt=""-->
<!--                    loading="lazy"-->
<!--                />-->
<!--                <span>SISTEM TATA TERTIB</span>-->
                <img
                        src="<?php echo APP_URL?>/assets/image/Logo.svg"
                        alt=""
                        height="30"
                >
            </a>
            <div class="dropdown ms-auto">
                <a
                    class="nav-link dropdown-toggle hidden-arrow align-items-center"
                    href="#"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <img
                        src="<?php echo APP_URL?>/assets/image/logo-polinema.png"
                        class="rounded-circle"
                        height="22"
                        alt=""
                        loading="lazy"
                    />
                    <span><?php echo $_COOKIE['SISTEM-TATA-TERTIB-USERNAME'] ?? 'Default Title'; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?php echo APP_URL . '/logout'?>">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            Logout
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo APP_URL . '/mahasiswa/profil'?>">
                            <i class="bi bi-person-circle me-2"></i>
                            Profil
                        </a>
                    </li>
                </ul>
            </div>
            <button
                class="navbar-toggler rounded-0 shadow-none p-2 border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="bi bi-list"></i>
            </button>
        </div>
    </nav>
</header>
