<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;

class HomeController implements Controller
{

    function index()
    {
        View::redirect("/dashboard");
    }
}