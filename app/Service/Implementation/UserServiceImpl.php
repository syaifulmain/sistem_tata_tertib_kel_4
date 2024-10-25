<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Config\Database;
use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Domain\UserRole;
use Kelompok2\SistemTataTertib\Exception\ValidationException;
use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaRequest;
use Kelompok2\SistemTataTertib\Model\User\UserRegisterMahasiwaResponse;
use Kelompok2\SistemTataTertib\Model\User\UserUpdateRequest;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\UserService;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerMahasiwaUser(UserRegisterMahasiwaRequest $request): UserRegisterMahasiwaResponse
    {
        if ($request->username === null || trim($request->username) === "") {
            throw new ValidationException("Username is required");
        }

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findUserByUsername($request->username);
            if ($user !== null) {
                throw new ValidationException("Username already exists");
            }
            $user = new User();
            $user->username = $request->username;
            $user->password = password_hash($request->username, PASSWORD_BCRYPT);
            $user->role = UserRole::MAHASISWA;

            $this->userRepository->save($user);

            $response = new UserRegisterMahasiwaResponse();
            $response->user = $user;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    public function updateUserPassword(UserUpdateRequest $request): bool
    {
        if ($request->newPassword === null || trim($request->newPassword) === ""
            || $request->oldPassword === null || trim($request->oldPassword) === "") {
            throw new ValidationException("Password is required");
        }

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findUserByUsername($request->username);
            if ($user === null) {
                throw new ValidationException("User not found");
            }

            if (!password_verify($request->oldPassword, $user->password)) {
                throw new ValidationException("Old password is incorrect");
            }

            $request->newPassword = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $request->updated_at = date("Y-m-d H:i:s");

            $result = $this->userRepository->update($request);
            Database::commitTransaction();
            return $result;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }
}