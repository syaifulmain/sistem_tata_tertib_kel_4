<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Domain\Session;
use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Repository\SessionRepository;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\SessionService;

class SessionServiceImpl implements SessionService
{
    public static string $LOGIN_SESSION_NAME = "SISTEM-TATA-TERTIB-LOGIN-SESSION";
    public static string $CURRENT_USER = "SISTEM-TATA-TERTIB-USERNAME";

    private SessionRepository $sessionRepository;

    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    function create(string $username): void
    {
        $session = new Session();
        $session->session_token = uniqid();
        $session->username = $username;

        $this->sessionRepository->save($session);

        setcookie(self::$LOGIN_SESSION_NAME, $session->session_token, time() + (60 * 60 * 24 * 30), "/");
    }

    function destroy(): void
    {
        $sessionToken = $_COOKIE[self::$LOGIN_SESSION_NAME] ?? '';
        $this->sessionRepository->deleteBySessionToken($sessionToken);

        setcookie(self::$LOGIN_SESSION_NAME, '', 1, "/");
        setcookie(self::$CURRENT_USER, '', 1, "/");
    }

    function current(): ?User
    {
        $sessionToken = $_COOKIE[self::$LOGIN_SESSION_NAME] ?? '';

        $session = $this->sessionRepository->findBySessionToken($sessionToken);
        if ($session == null) {
            return null;
        }

        return $this->userRepository->findUserByUsername($session->username);
    }

    function cantLoginMultipleDevice(string $username): void
    {
        $checkSession = $this->sessionRepository->checkSessionIsExitByUsername($username);
        if ($checkSession) {
            $this->sessionRepository->deleteSessionByUsername($username);
        }
    }
}