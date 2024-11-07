<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;

class UserController implements Controller
{

    function index()
    {
        View::render("login",[]);
    }

    function postLogin()
    {

    }
}