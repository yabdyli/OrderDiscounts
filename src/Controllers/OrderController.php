<?php


namespace App\Controllers;

use App\Models\Order;

class OrderController
{


	public function makeOrder($orderData, $productData)
	{

		$newOrder = new Order($orderData->{'customer-id'});

		foreach($orderData->items as $product){

			$originalProduct = array_search($product->{'product-id'}, array_column($productData,'id'));
			
			$newOrder->add(
						$product->{'product-id'},
						$product->{'unit-price'},
						$productData[$originalProduct]->description,
						$product->{'quantity'},
						$productData[$originalProduct]->category
					);
		}

		return $newOrder->getProducts();
	}

}