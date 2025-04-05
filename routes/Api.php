<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here you can register all of the routes for your application.
| It's simple. Just tell Lumen the URIs it should respond to,
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/auth/login', 'AuthController@login');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/stock/metrics', 'StockController@metrics');

    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->post('/users/collaborators', 'UserController@store');
        $router->delete('/users/collaborators/{uuid}', 'UserController@destroy');
        
        $router->delete('/products/{uuid}', 'ProductController@destroy');
        $router->post('/products', 'ProductController@store');
        $router->get('/products/export/category/{category_id}', 'ProductController@export');
        
        $router->post('/providers', 'ProviderController@store');
        $router->put('/providers/{uuid}', 'ProviderController@update');
        $router->delete('/providers/{uuid}', 'ProviderController@destroy');
        $router->get('/providers/export', 'ProviderController@export'); 
        
        $router->post('/categories', 'CategoryController@store');
        $router->put('/categories/{uuid}', 'CategoryController@update');
        $router->delete('/categories/{uuid}', 'CategoryController@destroy');

        $router->get('/purchase', 'PurchaseController@index');
        $router->get('/purchase/{uuid}', 'PurchaseController@show');
        $router->post('/purchase', 'PurchaseController@store');
        $router->put('/purchase/{uuid}', 'PurchaseController@update');
    });

    $router->put('/users/{uuid}/edit', 'UserController@update');
    $router->get('/users/collaborators', 'UserController@index');

    $router->get('/products', 'ProductController@index');
    $router->get('/products/{uuid}', 'ProductController@show');
    $router->put('/products/{uuid}', 'ProductController@update');
    $router->put('/products/{uuid}/quantity', 'ProductController@updateQuantity');
    
    $router->get('/providers', 'ProviderController@index');
    $router->get('/providers/{uuid}', 'ProviderController@show');
    
    $router->get('/categories', 'CategoryController@index');
    $router->get('/categories/{uuid}', 'CategoryController@show');
    
    $router->get('/request/purchase', 'RequestPurchaseController@store');
});


$router->get('/', function () {
    return response('<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Rota Não Autorizada</title><style>body{display:flex;justify-content:center;align-items:center;height:100vh;background:#f1f1f1;font-family:Arial, sans-serif;text-align:center;flex-direction:column;} h1{color:#d9534f;} p{color:#333;}</style></head><body><h1>Rota Não Autorizada</h1><p>Você não tem permissão para acessar esta rota.</p></body></html>', 403);
});

$router->get('/docs', function () {
    return response()->file(base_path('public/docs-ui/dist/index.html'));
});

$router->options('{any:.*}', function () {
    return response('', 200);
});