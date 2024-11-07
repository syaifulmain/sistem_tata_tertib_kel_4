<?php

namespace Kelompok2\SistemTataTertib\Service\Implementation;

use Kelompok2\SistemTataTertib\Domain\Session;
use Kelompok2\SistemTataTertib\Domain\User;
use Kelompok2\SistemTataTertib\Repository\SessionRepository;
use Kelompok2\SistemTataTertib\Repository\UserRepository;
use Kelompok2\SistemTataTertib\Service\SessionService;

class SessionServiceImpl implements SessionService
{

    public static string $COOKIE_NAME = "X-LOGIN-SESSION";

    private SessionRepository $sessionRepository;

    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }
    function create(int $user_id): Session
    {
        $session = new Session();
        $session->session_token = uniqid();
        $session->user_id = $user_id;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->user_id, time() + (60 * 60 * 24 * 30), "/");

        return $session;
    }

    function destroy(): void
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

//        $this->sessionRepository->deleteAll(); // <-- raja iblis

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->userRepository->findUserById($session->user_id);
    }
}