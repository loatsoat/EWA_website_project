<?php
declare(strict_types=1);

class Router
{
    public function getRoute(): string
    {
        // support both 'route' (used by .htaccess) and 'url' (framework style)
        $route = (string) ($_GET['route'] ?? $_GET['url'] ?? '');
        return trim($route, '/');
    }

    public static function generateUrl(string $path = '', array $params = []): string
    {
        $base = rtrim(dirname((string)$_SERVER['SCRIPT_NAME']), '/');
        $path = ltrim($path, '/');
        $url = $path === '' ? $base . '/' : $base . '/' . $path;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $url;
    }
}
