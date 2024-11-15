<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <style>
        @media (min-width: 992px) {
            #navbarMenu {
                display: none !important;
            }
        }
        .sidebar {
            transition: width 0.3s ease; /* Animasi geser sederhana */
            width: 225px !important;
        }

        .collapsed-sidebar {
            width: 75px !important;
        }

        .collapsed-sidebar .sidebar-text {
            display: none;
        }
    </style>
</head>
<body class="bg-dark">
<header>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-0 px-md-4 px-2 shadow">
        <a class="navbar-brand" href="#">Navbar</a>
        <div class="dropdown ms-auto">
            <button class="btn btn-dark dropdown-toggle rounded-0 text-white" type="button"
                    id="navbarDropdownMenuLink"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-0-circle-fill"></i>
                <span class="d-none d-sm-inline">Danny/123123123</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
            </div>
        </div>
        <button class="navbar-toggler btn btn-dark rounded-0 shadow-none p-2 border-0 text-white"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse d-lg-none py-md-4" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                       href="http://localhost:8080/dashboard" data-load>
                        <i class="bi bi-speedometer2 h4"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                       href="http://localhost:8080/biodata/mahasiswa/index" data-load>
                        <i class="bi bi-person-vcard-fill h4"></i>
                        <span class="sidebar-text">Biodata</span>
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                       href="http://localhost:8080/peraturan/index" data-load>
                        <i class="bi bi-gear h4"></i>
                        <span class="sidebar-text">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="container-fluid bg-white">
    <div class="row">
        <div class="w-auto d-none d-lg-block bg-dark p-0 sidebar" id="sidebarMenu">
            <button class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white w-100" type="button"
                    id="toggleSidebar">
                <i class="bi bi-list h3"></i>
            </button>
            <ul class="navbar-nav text-white">
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                            href="http://localhost:8080/dashboard" data-load>
                        <i class="bi bi-speedometer2 h4"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                            href="http://localhost:8080/biodata/mahasiswa/index" data-load>
                        <i class="bi bi-person-vcard-fill h4"></i>
                        <span class="sidebar-text">Biodata</span>
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a class="btn btn-dark rounded-0 shadow-none p-2 border-0 text-white d-flex align-items-center px-4 gap-2 w-100"
                            href="http://localhost:8080/peraturan/index" data-load>
                        <i class="bi bi-gear h4"></i>
                        <span class="sidebar-text">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col bg-secondary-subtle p-lg-3 p-2">
            <div class="h-100 bg-white p-2" style="min-height: 85vh">
                <div class="border border-secondary-subtle px-lg-2 py-lg-3 px-1 py-2">
                    <main id="main-content" class="text-dark">