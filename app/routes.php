<?php

require 'app/controllers/indexController.php';
require 'app/controllers/ordersController.php';
require 'app/controllers/productsController.php';

$router->get('FreshFoodAPI', 'indexController@home');
$router->get('FreshFoodAPI/orders', 'ordersController@readAll');
$router->get('FreshFoodAPI/products', 'productsController@readAll');
$router->get('FreshFoodAPI/orders/Co2', 'ordersController@readSpareCo2');

$router->post('FreshFoodAPI/orders', 'ordersController@createOrder');
$router->post('FreshFoodAPI/products', 'productsController@createProduct');

$router->patch('FreshFoodAPI/orders/:id', 'ordersController@updateOrder');
$router->patch('FreshFoodAPI/products/:name', 'productsController@updateProduct');

$router->delete('FreshFoodAPI/orders/:id', 'ordersController@deleteOrder');
$router->delete('FreshFoodAPI/products/:name', 'productsController@deleteProduct');


var_dump($router->routes);
