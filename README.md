## Synopsis

Implementation local interface for Tiket.com API.

## Code Example

Generate URL for Tiket.com API with the given data
```
Sample generate url
-----
$url = get_url(
    "https://api-sandbox.tiket.com/partner/transactionApi",
    $data
);
```

## Motivation

First step for further development reservation app from Tiket.com

## Installation

1. Require install
- PHP (PHP ver 5 or greater)
- Web Server (Apache ver 2 or greater, Nginx 1 or greater)

2. Serve

3. Request local interface
```
Sample request local interface
-----
http://uftiket.app/?entoken=0&action=transaction
http://uftiket.app/?entoken=1&action=order_delete&order_detail_id=43226749
http://uftiket.app/?entoken=1&action=checkout_payment&payment_method=&btn_booking=0
```
## API Reference

Documentation [Tiket.com API](http://docs.tiket.com/)

## Contributors

- Laode Urfan la.urfan.91@gmail.com

