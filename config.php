<?php

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'];

return (object) array(
    'SITE_ROOT' => "/" . basename(__DIR__),
    'SITE_NAME' => "Little Wonders",
    'SITE_URL' => $base_url
);
