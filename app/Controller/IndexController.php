<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Repository\Implementation\SessionRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\UserRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\SessionServiceImpl;
use Kelompok2\SistemTataTertib\Service\SessionService;

class IndexController implements Controller
{
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnection()),
            new UserRepositoryImpl(Database::getConnection())
        );
    }

    function index(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/login');
        } else {
            if ($user->level == 'admin') {
                View::redirect('/home/admin');
            }
        }
    }
}