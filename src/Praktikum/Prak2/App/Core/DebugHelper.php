<?php
declare(strict_types=1);

class DebugHelper
{
    public function __construct()
    {
        error_reporting(E_ALL);
    }

    public static function dump(mixed $var): void
    {
        echo '<pre style="background:#1e1e1e; color:#00ff00; padding:10px; font-family:monospace; font-size:14px;">';
        var_dump($var);
        echo '</pre>';
    }
}

if (!function_exists('dump')) {
    function dump(...$vars): void
    {
        foreach ($vars as $v) {
            DebugHelper::dump($v);
        }
    }
}
