<?php
declare(strict_types=1);

class Router
{
    public function getRoute(): string
    {
        $raw = (string) ($_GET['route'] ?? $_GET['url'] ?? '');
        return trim($raw, '/');
    }

    public function getRouteSegments(): array
    {
        $route = $this->getRoute();
        return $route === '' ? [] : explode('/', $route);
    }

    public static function generateUrl(string $path = '', array $params = []): string
    {
        $base = rtrim(dirname((string) $_SERVER['SCRIPT_NAME']), '/');
        $path = ltrim($path, '/');
        $url  = $path === '' ? $base . '/' : $base . '/' . $path;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}
