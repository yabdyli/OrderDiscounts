<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\OrderController;


// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
$router->get('/', function() {

	echo "Welcome to OrderDiscount Microservice!";

});

$router->post('/order',  OrderController::saveOrder());

// Run it!
$router->run();


