<?php
declare(strict_types=1);

class LoginController extends BaseController
{
    private string $message = '';

    private function normalizeRole(string $role): string
    {
        return in_array($role, ['baker', 'driver'], true) ? $role : 'baker';
    }

    private function normalizeRedirect(string $redirect, string $fallback): string
    {
        return in_array($redirect, ['order', 'customer', 'baker', 'driver', 'login'], true) ? $redirect : $fallback;
    }

    protected function processData(): void
    {
        AuthHelper::ensureSession();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $role     = $this->normalizeRole((string) ($_POST['role'] ?? $_GET['role'] ?? 'baker'));
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $redirect = $this->normalizeRedirect((string) ($_POST['redirect'] ?? $role), $role);

        if (AuthHelper::login($role, $username, $password)) {
            header('Location: ' . Router::generateUrl($redirect));
            exit;
        }

        $this->message = 'Login fehlgeschlagen. Bitte Daten prüfen.';
    }

    public function generateResponse(): string
    {
        $role     = $this->normalizeRole((string) ($_GET['role'] ?? 'baker'));
        $redirect = $this->normalizeRedirect((string) ($_GET['redirect'] ?? $role), $role);

        ob_start();
        $this->renderHtml('login.view.php', [
            'title'    => 'Login',
            'role'     => $role,
            'redirect' => $redirect,
            'message'  => $this->message,
        ]);
        return (string) ob_get_clean();
    }

    public function handleRequest(): void
    {
        $this->processData();
        echo $this->generateResponse();
    }
}
