<?php

$appHost = parse_url((string) env('APP_URL', ''), PHP_URL_HOST);
$configuredHeroHosts = explode(',', (string) env('HERO_ALLOWED_LINK_HOSTS', ''));

return [
    'hero_allowed_link_hosts' => array_values(array_unique(array_filter([
        is_string($appHost) ? strtolower($appHost) : null,
        ...array_map(
            static fn (string $host): string => strtolower(trim($host)),
            $configuredHeroHosts,
        ),
    ]))),
];
