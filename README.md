# Demo for Broadway - EventSourcing library for PHP

This repository contains a demo application to show how [Broadway] can be used within a Symfony application.
The starting point is take from the [Broadway demo]

[Broadway]: https://github.com/broadway/broadway
[Broadway demo]: https://github.com/broadway/broadway-demo

## Running the app

```
composer install
bin/console broadway:event-store:create
bin/console broadway:read-model-related:create
bin/console broadway:read-model-total:create
bin/console server:run
```

This demo doesn't have a GUI, only an API with the following endpoints:

| Method | Path | Description |
|--------|------|-------------|
| POST | `/basket` | Pick up a new basket, returns the basketId |
| POST | `/basket/{basketId}/addProduct` | Add a product to a basket (productId and productName should be given as form fields) |
| POST | `/basket/{basketId}/removeProduct` | Remove a product from a basket (productId as form field) |
| POST | `/basket/{basketId}/checkout` | Check out a basket |
| GET | `/advice/{productId}` | Retrieve _Other people also bought this_ list |

```bash
# pick up a new basket
$ curl -X POST http://localhost:8000/basket
{
  "id":"1bd683ac-f75d-403f-babc-82ddcdb33de7"
}

# add products to the basket
$ curl -d "productId=2009&productName=Incredibad" -X POST http://localhost:8000/basket/1bd683ac-f75d-403f-babc-82ddcdb33de7/addProduct
$ curl -d "productId=2011&productName=Turtleneck+%26+Chain" -X POST http://localhost:8000/basket/1bd683ac-f75d-403f-babc-82ddcdb33de7/addProduct
$ curl -d "productId=2013&productName=The+Wack+Album" -X POST http://localhost:8000/basket/1bd683ac-f75d-403f-babc-82ddcdb33de7/addProduct

# remove a product from the basket
curl -d "productId=2009" -X POST http://localhost:8000/basket/1bd683ac-f75d-403f-babc-82ddcdb33de7/removeProduct

# check out the basket
$ curl -X POST http://localhost:8000/basket/1bd683ac-f75d-403f-babc-82ddcdb33de7/checkout

# get _Other people also bought this_ list
$ curl http://localhost:8000/advice/2011
{
  "purchasedProductId": 2011,
  "otherProducts": {
    "2009": 1,
    "2013": 1
  }
}
```
