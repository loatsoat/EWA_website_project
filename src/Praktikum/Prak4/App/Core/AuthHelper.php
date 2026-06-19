<?php
declare(strict_types=1);

class AuthHelper
{
    private const SESSION_ROLE = 'auth_role';
    private const SESSION_USER = 'auth_user';

    private const CREDENTIALS = [
        'baker'  => ['username' => 'baker',  'password' => 'baker123'],
        'driver' => ['username' => 'driver', 'password' => 'driver123'],
    ];

    public static function ensureSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login(string $role, string $username, string $password): bool
    {
        self::ensureSession();

        $role = strtolower(trim($role));

        if (!isset(self::CREDENTIALS[$role])) {
            return false;
        }

        $expected = self::CREDENTIALS[$role];

        if ($username !== $expected['username'] || $password !== $expected['password']) {
            return false;
        }

        $_SESSION[self::SESSION_ROLE] = $role;
        $_SESSION[self::SESSION_USER] = $username;

        return true;
    }

    public static function logout(): void
    {
        self::ensureSession();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], (bool) $p['secure'], (bool) $p['httponly']);
        }

        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        self::ensureSession();
        return isset($_SESSION[self::SESSION_ROLE]);
    }

    public static function getRole(): string
    {
        self::ensureSession();
        return (string) ($_SESSION[self::SESSION_ROLE] ?? '');
    }

    public static function getUser(): string
    {
        self::ensureSession();
        return (string) ($_SESSION[self::SESSION_USER] ?? '');
    }

    public static function requireRole(string $role): void
    {
        self::ensureSession();

        if (self::getRole() === $role) {
            return;
        }

        header('Location: ' . Router::generateUrl('login', ['role' => $role, 'redirect' => $role]));
        exit;
    }
}
