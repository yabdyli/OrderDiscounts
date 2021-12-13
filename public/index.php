<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Order;
use App\Models\Product;

$order_input = json_decode(file_get_contents('../example-orders/order3.json'));

$product_inputs = json_decode(file_get_contents('../data/products.json'));

$newOrder = new Order($order_input->{'customer-id'});

foreach($order_input->items as $product){

	$original_product = array_search($product->{'product-id'}, array_column($product_inputs,'id'));
	
	$newOrder->add(
				$product->{'product-id'},
				$product->{'unit-price'},
				$product_inputs[$original_product]->description,
				$product->{'quantity'},
				$product_inputs[$original_product]->category
			);
}

print_r($newOrder->getProducts());