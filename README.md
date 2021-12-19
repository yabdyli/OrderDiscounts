# Order Discounts

## Setup

Install composer:
```shell
$ composer install
```

Run project:
```shell
$ php -S localhost:8000 -t public 
```
Run PHPUnit tests
```shell
$ ./vendor/bin/phpunit
```

API Endpoint
```shell
POST /orders
```

JSON example
```shell
{
  "id": "3",
  "customer-id": "3",
  "items": [
    {
      "product-id": "A101",
      "quantity": "2",
      "unit-price": "9.75",
      "total": "19.50"
    },
    {
      "product-id": "A102",
      "quantity": "1",
      "unit-price": "49.50",
      "total": "49.50"
    }
  ],
  "total": "69.00"
}
```

For Developers
You can add new Discounts by implementing DiscountInterface and then apply that Discount in OrderController.