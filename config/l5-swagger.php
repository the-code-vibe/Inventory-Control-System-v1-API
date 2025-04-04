<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => env('L5_SWAGGER_TITLE', 'Gerenciador de estoque'),
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'docs' => base_path('public/docs'),
                'swagger_ui_assets_path' => base_path('vendor/swagger-ui'),
                'annotations' => base_path('app'),
                'swagger_json' => storage_path('api-docs/swagger.json'),
            ],
        ],
    ],
    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
    'swagger_version' => env('L5_SWAGGER_VERSION', '3.0'),
    'security' => [
        'api_key' => [
            'type' => 'apiKey',
            'in' => 'header',
            'name' => 'Authorization',
        ],
    ],
];