<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;

class HomeController implements Controller
{

    function index(): void
    {
        View::render('/landingpage/index', [
            'data' => [
                'title' => 'Home'
            ]
        ], false);
    }
}