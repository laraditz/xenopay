# Xenopay
Xenopay SDK for Laravel

## Installation

Via Composer

``` bash
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

## Usage

Example usage as below snippet:
```php
// using Facade
$response = \Xenopay::auth()->login(['email' => 'test@mail.com', 'password' => 'password']);

// using Service Container
$response = app('Xenopay')->auth()->login(['email' => 'test@mail.com', 'password' => 'password']);
```
The request returns an instance of `Laraditz\Xenopay\XenopayResponse`, which provides a variety of methods that may be used to inspect the response:
```php
$response->isSuccess() : bool; // true or false

$response->status() : int; // http status code. e.g. 200, 400, 500 etc.

$response->message() : string; // message for the response. e.g. "Invalid data".

$response->data() : mixed; // response content

$response->errors() : array; // usually contain validation errors
```

## Credits

- [Raditz Farhan](https://github.com/raditzfarhan)

## License

MIT. Please see the [license file](LICENSE) for more information.

