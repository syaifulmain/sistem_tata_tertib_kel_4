<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Exception\ValidationException;
use Kelompok2\SistemTataTertib\Model\User\UserLoginRequest;
use Kelompok2\SistemTataTertib\Model\User\UserLoginResponse;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\UserService;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

        if (!password_verify($request->password, $user->password)) {
            throw new ValidationException("Username or password is incorrect");
        }

        $response = new UserLoginResponse();
        $response->username = $user->username;
        $response->level = $user->level;
        return $response;
    }
}