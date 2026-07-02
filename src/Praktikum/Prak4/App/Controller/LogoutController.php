<?php
declare(strict_types=1);

class LogoutController extends BaseController
{
    public function handleRequest(): void
    {
        AuthHelper::logout();
        header('Location: ' . Router::generateUrl('login'));
        exit;
    }
}
