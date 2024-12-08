<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Exception\ValidationException;
use Kelompok2\SistemTataTertib\Model\User\CreateUserRequest;
use Kelompok2\SistemTataTertib\Model\User\UpdateUserRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginResponse;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\UserService;

class UserServiceImpl implements UserService
{

    public static string $LOGIN_SESSION_NAME = "SISTEM-TATA-TERTIB-LOGIN-SESSION";
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    function createUser(CreateUserRequest $request): void
    {
        if ($request->username === null || trim($request->username) === ""
            || $request->password === null || trim($request->password) === ""
            || $request->level === null || trim($request->level) === "") {
            throw new ValidationException("Username, password, and level is required");
        }

        $user = $this->userRepository->findUserByUsername($request->username);
        if ($user !== null) {
            throw new ValidationException("Username already exists");
        }

        try {
            Database::beginTransaction();
            $user = new User();
            $user->username = $request->username;
//            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
            $user->password = $request->password;
            $user->level = $request->level;

            $this->userRepository->save($user);
            Database::commitTransaction();
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw new \Exception("Gagal Menyimpan User");
        }
    }

    function updateUser(UpdateUserRequest $request): bool
    {
        // TODO: Implement updateUser() method.
        return false;
    }

    function login(UserLoginRequest $request): UserLoginResponse
    {
        if ($request->username === null || trim($request->username) === ""
            || $request->password === null || trim($request->password) === "") {
            throw new ValidationException("Username and password is required");
        }

        $user = $this->userRepository->findUserByUsername($request->username);
        if ($user === null) {
            throw new ValidationException("User not found");
        }

        if ($request->password !== $user->password) {
            throw new ValidationException("Username or Password is incorrect");
        }

        $response = new UserLoginResponse();
        $response->username = $user->username;
        $response->level = $user->level;
        return $response;
    }
}