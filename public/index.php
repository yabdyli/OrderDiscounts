<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Order;
use App\Models\Product;
use App\Controllers\OrderController;

$order_input = json_decode(file_get_contents('../example-orders/order3.json'));

$product_inputs = json_decode(file_get_contents('../data/products.json'));

//$newOrder = new OrderController();

print_r(OrderController::makeOrder($order_input, $product_inputs));