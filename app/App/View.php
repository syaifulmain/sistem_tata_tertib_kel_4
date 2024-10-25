<?php

namespace Kelompok2\SistemTataTertib\App;

class View
{

    public static function render(string $view, $model, bool $templete = true): void
    {
        if ($templete) {
            require __DIR__ . '/../View/header.php';
            require __DIR__ . '/../View/' . $view . '.php';
            require __DIR__ . '/../View/footer.php';
        } else {
            require __DIR__ . '/../View/' . $view . '.php';
        }
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
        if (getenv("mode") != "test") {
            exit();
        }
    }

}