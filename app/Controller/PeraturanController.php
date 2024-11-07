<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;

class PeraturanController implements Controller
{

    function index()
    {
        View::render('peraturan', []);
    }
}