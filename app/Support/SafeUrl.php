<?php

namespace App\Support;

final class SafeUrl
{
    public static function http(?string $url, bool $httpsOnly = false): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $allowedSchemes = $httpsOnly ? ['https'] : ['http', 'https'];

        if (! in_array($scheme, $allowedSchemes, true)) {
            return null;
        }

        if (parse_url($url, PHP_URL_USER) !== null || parse_url($url, PHP_URL_PASS) !== null) {
            return null;
        }

        return $url;
    }
}
