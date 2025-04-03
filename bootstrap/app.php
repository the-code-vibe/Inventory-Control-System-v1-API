<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
*/
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
*/
$app->configure('app');
$app->configure('mail');
$app->configure('database');
$app->configure('view');
$app->configure('logging');

$app->instance('config', new \Illuminate\Config\Repository([
    'mail' => [
        'default' => env('MAIL_MAILER', 'smtp'),
        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.gmail.com'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
            ],
        ],
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example App'),
        ],
    ]
]));

$app->instance('config', new \Illuminate\Config\Repository(array_merge(
    $app->make('config')->all(),
    [
        'database' => [
            'default' => env('DB_CONNECTION', 'mysql'),
            'connections' => [
                'mysql' => [
                    'driver'    => 'mysql',
                    'host'      => env('DB_HOST', '127.0.0.1'),
                    'port'      => env('DB_PORT', 3306),
                    'database'  => env('DB_DATABASE', 'inventory_db'),
                    'username'  => env('DB_USERNAME', 'root'),
                    'password'  => env('DB_PASSWORD', ''),
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                    'engine'    => null,
                ],
            ],
        ]
    ]
)));

$app->instance('config', array_merge($app->make('config')->all(), [
    'view.paths' => [base_path('resources/views')],
    'view.compiled' => storage_path('framework/views'),
]));

$app->instance('config', array_merge($app->make('config')->all(), [
    'logging.default' => env('LOG_CHANNEL', 'stack'),
    'logging.channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/lumen.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],
]));

$app->register(Laravel\Lumen\Console\ConsoleServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(Laravel\Tinker\TinkerServiceProvider::class);
$app->register(Illuminate\View\ViewServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/
$app->routeMiddleware([
    'auth'            => App\Http\Middleware\Authenticate::class,
    'jwt.auth'        => Tymon\JWTAuth\Http\Middleware\Authenticate::class,
    'AuthenticateAdmin' => App\Http\Middleware\AuthenticateAdmin::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/api.php';
});

return $app;
