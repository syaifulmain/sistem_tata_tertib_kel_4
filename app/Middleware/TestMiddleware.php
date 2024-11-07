<?php

namespace Kelompok2\SistemTataTertib\Middleware;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Middleware\Middleware;

class TestMiddleware implements Middleware
{

    function before(): void
    {
        if (getenv("mode") != "test") {
            View::render("error", [
                'error' => 'error',
            ]);
            exit();
        }
    }
}