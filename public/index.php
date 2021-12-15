<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Order;
use App\Models\Product;
use App\Controllers\OrderController;

$order_input = json_decode(file_get_contents('../example-orders/order1.json'));

$product_inputs = json_decode(file_get_contents('../data/products.json'));

$customer_input = json_decode(file_get_contents('../data/customers.json'));


$result = OrderController::makeOrder($order_input, $product_inputs,$customer_input);

print_r($result);