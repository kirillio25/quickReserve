    <?php

    return [
        'paths' => ['api/*', 'admin/*', 'sanctum/csrf-cookie'],
        'allowed_methods' => ['*'],
        'allowed_origins' => ['http://localhost:8080'],
        'allowed_headers' => ['*'],
        'supports_credentials' => true,
    ];

