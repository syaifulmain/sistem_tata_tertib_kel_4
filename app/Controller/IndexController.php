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
            View::redirect('/home');
        } else {
            if ($user->level == 'admin') {
                View::redirect('/admin/home');
            } elseif ($user->level == 'dosen') {
                View::redirect('/dosen/home');
            } elseif ($user->level == 'mahasiswa') {
                View::redirect('/mahasiswa/home');
            }
        }
    }
}