<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo APP_URL?>/assets/css/bootstrap-edit.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            padding: 58px 0 0; /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-primary">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4 gap-3 ">
                <a
                        href="<?php echo APP_URL?>/admin/home"
                        class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                        aria-current="true"
                >
                    <i class="bi bi-house me-3"></i>
                    <span>Home</span>
                </a>
                <a
                        href="<?php echo APP_URL?>/admin/mahasiswa/index"
                        class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                >
                    <i class="bi bi-backpack me-3"></i>
                    <span>Mahasiswa</span>
                </a>
                <a
                        href="<?php echo APP_URL?>/admin/dosen/index"
                        class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                >
                    <i class="bi bi-duffle me-3"></i>
                    <span>Dosen</span>
                </a>
                <a
                        href="#"
                        class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                        data-bs-toggle="collapse"
                        data-bs-target="#submenuSistemTataTertib"
                        aria-expanded="false"
                >
                    <i class="bi bi-clipboard-data me-3"></i>
                    <span>Sistem Tata Tertib</span>
                    <i class="bi bi-caret-left-fill float-end" id="chevronSistemTataTertib"></i>
                </a>
                <div class="collapse" id="submenuSistemTataTertib">
                    <a
                            href="#"
                            class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                    >
                        <i class="bi bi-plus-circle me-3"></i>
                        <span>Tambah Tata Tertib</span>
                    </a>
                    <a
                            href="#"
                            class="list-group-item list-group-item-primary list-group-item-action py-2 ripple border-0 rounded-2"
                    >
                        <i class="bi bi-trash me-3"></i>
                        <span>Hapus Tata Tertib</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img
                        src="#"
                        height="25"
                        alt=""
                        loading="lazy"
                />
                <span>SISTEM TATA TERTIB</span>
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
                    <span class="ms-1 d-none d-sm-inline">ADMIN</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?php echo APP_URL . '/logout'?>">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            Logout
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
