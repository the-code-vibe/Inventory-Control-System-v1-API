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
$app->configure('l5-swagger');

$app->register(Laravel\Lumen\Console\ConsoleServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Laravel\Tinker\TinkerServiceProvider::class);
$app->register(Illuminate\View\ViewServiceProvider::class);
$app->singleton(Illuminate\Contracts\Routing\ResponseFactory::class, Illuminate\Routing\ResponseFactory::class);
$app->register(Illuminate\Routing\RoutingServiceProvider::class);
$app->register(\L5Swagger\L5SwaggerServiceProvider::class);
$app->register(L5Swagger\L5SwaggerServiceProvider::class);

$app->configure('app');
$app->configure('view');

$app->bind('path.public', function () {
    return base_path('public');
});

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
