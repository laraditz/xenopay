# Xenopay

[![Latest Stable Version](https://poser.pugx.org/laraditz/xenopay/v/stable?format=flat-square)](https://packagist.org/packages/laraditz/xenopay)
[![Total Downloads](https://img.shields.io/packagist/dt/laraditz/xenopay?style=flat-square)](https://packagist.org/packages/laraditz/xenopay)
[![License](https://poser.pugx.org/laraditz/xenopay/license?format=flat-square)](https://packagist.org/packages/laraditz/xenopay)
[![StyleCI](https://github.styleci.io/repos/7548986/shield?style=square)](https://github.com/laraditz/xenopay)

Xenopay SDK for Laravel.

## Installation

Via Composer

```bash
$ composer require laraditz/xenopay
```

## Configuration

Edit the `config/app.php` file and add the following line to register the service provider:

```php
'providers' => [
    ...
    Laraditz\Xenopay\XenopayServiceProvider::class,
    ...
],
```

> Tip: If you're on Laravel version **5.5** or higher, you can skip this part of the setup in favour of the Auto-Discovery feature.

You can set default Xenopay account in your `.env` so that you do not need to pass it everytime you login.
```
...
XENOPAY_EMAIL=
XENOPAY_PASSWORD=
...
``` 

## Getting started
Execute migration file:
```bash
php artisan migrate
```

## Usage

Example usage as below snippet:
```php
// using Facade
$response = \Xenopay::auth()->login(['email' => 'test@mail.com', 'password' => 'password']);

// using Service Container
$response = app('Xenopay')->auth()->login(['email' => 'test@mail.com', 'password' => 'password']);

// login
$response = \Xenopay::auth()->login(); // if u have set default account in .env, do not need to pass anything

// create bill
$response = \Xenopay::bill()->withToken($access_token)->create([
    'ref_no' => 'youruniquereferenceno',
    'amount' => 1,
    'description' => 'your description here.',
    'contact' => '0121234567',
    'redirect_url' => 'https://yourapp.com',
]);

// view bill
$response = \Xenopay::bill()->withToken($access_token)->view($id);
```
The request returns an instance of `Laraditz\Xenopay\XenopayResponse`, which provides a variety of methods that may be used to inspect the response:
```php
$response->isSuccess() : bool; // true or false

$response->status() : int; // http status code. e.g. 200, 400, 500 etc.

$response->message() : string; // message for the response. e.g. "Invalid data".

$response->data() : mixed; // response content

$response->errors() : array; // usually contain validation errors
```

## Change log

Please see the [changelog](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Raditz Farhan](https://github.com/raditzfarhan)

## License

MIT. Please see the [license file](LICENSE) for more information.

