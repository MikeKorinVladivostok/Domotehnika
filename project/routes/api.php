<?php

/** @var \Illuminate\Routing\Router $router */
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->get('catalog', 'Catalog\\CatalogController@index');
$router->get('catalog/{id}', 'Catalog\\CatalogController@advert');
$router->get('payment', 'Catalog\\CatalogController@getPaymentResponseAndUpdateAmount');
$router->get('paymentSystem', 'Catalog\\CatalogController@sendPaymentRequest');

