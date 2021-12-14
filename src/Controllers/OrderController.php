<?php

namespace App\Controllers;

use App\Models\Order;

class OrderController
{

	public static function makeOrder($orderData, $productData)
	{
		//Create new Order
		$newOrder = new Order($orderData->{'customer-id'});

		//Add new products in order and match them with provided json products 
		$newOrder->insertProducts($orderData, $productData);

		return $newOrder->getProducts();

	}

}