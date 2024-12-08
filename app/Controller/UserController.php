<?php

namespace Kelompok2\SistemTataTertib\Controller;

use Kelompok2\SistemTataTertib\App\View;
use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Exception\ValidationException;
use Kelompok2\SistemTataTertib\Model\User\UserLoginRequest;
use Kelompok2\SistemTataTertib\Repository\Implementation\SessionRepositoryImpl;
use Kelompok2\SistemTataTertib\Repository\Implementation\UserRepositoryImpl;
use Kelompok2\SistemTataTertib\Service\CurrentUserService;
use Kelompok2\SistemTataTertib\Service\Implementation\CurrentUserServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\SessionServiceImpl;
use Kelompok2\SistemTataTertib\Service\Implementation\UserServiceImpl;
use Kelompok2\SistemTataTertib\Service\SessionService;
use Kelompok2\SistemTataTertib\Service\UserService;

class UserController implements Controller
{

    private UserService $userService;

    private SessionService $sessionService;

    private CurrentUserService $currentUserService;

    public function __construct()
    {
        $this->userService = new UserServiceImpl(
            new UserRepositoryImpl(Database::getConnection())
        );

        $this->sessionService = new SessionServiceImpl(
            new SessionRepositoryImpl(Database::getConnection()),
            new UserRepositoryImpl(Database::getConnection())
        );

        $this->currentUserService = new CurrentUserServiceImpl(
            Database::getConnection()
        );
    }


    function index(): void
    {
        View::render('login', [
            'title' => 'Login'
        ], false);
    }

    function login(): void
    {
        $request = new UserLoginRequest();
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->login($request);
            $this->sessionService->cantLoginMultipleDevice($response->username);
            $this->sessionService->create($response->username);
            $this->currentUserService->getUsernameAndName($response->username);
            echo json_encode(['status' => 'OK']);
        } catch (ValidationException $exception) {
            http_response_code(400);
            echo json_encode(['error' => $exception->getMessage()]);
        }

    }

    function logout(): void
    {
        $this->sessionService->destroy();
        View::redirect('/');
    }
}