<?php

namespace Kelompok2\SistemTataTertib\Middleware;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Repository\Implementation\SessionRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\UserRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\SessionServiceImpl;
use Kelompok2\SistemTataTertib\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnection()),
            new UserRepositoryImpl(Database::getConnection())
        );
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            header('Location: /login');
            exit();
        }
    }
}