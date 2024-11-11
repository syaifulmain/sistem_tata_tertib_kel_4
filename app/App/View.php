<?php

namespace Kelompok2\SistemTataTertib\App;

class View
{
    public static function render(string $view, $model, bool $templete = true): void
    {
        $level = "";
        if (str_contains($view, "/")) {
            $parts = explode("/", $view);
            $level = reset($parts) . "/";
        }

//        require __DIR__ . '/../../config/aplication.php';
        if ($templete) {
            require __DIR__ . '/../View/' . $level . 'template/header.php';
            require __DIR__ . '/../View/' . $view . '.php';
            require __DIR__ . '/../View/' . $level . 'template/footer.php';
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