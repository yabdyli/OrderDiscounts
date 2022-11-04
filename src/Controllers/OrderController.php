<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Discounts\DiscountLoyalCustomer;
use App\Discounts\DiscountProductByCategory;
use App\Discounts\DiscountCheapestProduct;

class OrderController
{
    public static function saveOrder()
    {
        if (file_get_contents('php://input')) {
            $orderData = json_decode(file_get_contents('php://input'));

            $productData = json_decode(file_get_contents('../data/products.json'));

            $customerData = json_decode(file_get_contents('../data/customers.json'));

            //Create new Order
            $newOrder = new Order($orderData->{'customer-id'}, $orderData->total);

            //Add new products in order and match them with provided json products
            $newOrder->insertProducts($orderData, $productData);

            $originalCustomer = array_search($orderData->{'customer-id'}, array_column($customerData, 'id'));

            $customer = new Customer(
                $customerData[$originalCustomer]->id,
                $customerData[$originalCustomer]->name,
                $customerData[$originalCustomer]->since,
                $customerData[$originalCustomer]->revenue
            );

            $loaylDiscount = (new DiscountLoyalCustomer($customer))->discount($newOrder);

            $DiscountProductByCategory = (new DiscountProductByCategory($customer, 2))->discount($newOrder);

            $DiscountCheapestProduct = (new DiscountCheapestProduct($customer, 1))->discount($newOrder);

            header('Content-Type: application/json');

            echo json_encode($newOrder);
        }
    }
}
