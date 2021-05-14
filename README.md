# Immi.shop API PHP SDK

## Installation

Just use composer:
```sh
composer require imper86/php-immi-api
```

### HTTPlug note
This lib uses [HTTPlug](https://github.com/php-http/httplug)
so it doesn't depend on any http client. In order to use this
lib you must have some [PSR-18 http client](https://www.php-fig.org/psr/psr-18)
and [PSR-17 http factories](https://www.php-fig.org/psr/psr-17).
If you don't know which one you shoud install you can require
these:

```sh
composer require php-http/guzzle6-adapter http-interop/http-factory-guzzle
```

## Usage
Library has a bunch of mechanisms that allows you to forget about
tokens, expirations etc. But in order to start using it you must
authorize user using Oauth flow.

### Client credentials flow example

```php
use Http\Client\Common\Plugin\ErrorPlugin;
use Imper86\ImmiApi\Immi;
use Imper86\ImmiApi\Model\Credentials;
use Imper86\ImmiApi\Oauth\FileTokenRepository;
use Imper86\ImmiApi\Plugin\AuthPlugin;

$sandbox = true; //if set to false you will connect to production environment
$credentials = new Credentials(
    'your_client_id',
    'your_client_secret',
    null,
    $sandbox
);
$client = new Immi($credentials);

/*
 * You can invent your own TokenRepository, just implement
 * our TokenRepositoryInterface.
 * You can use your DB, Redis, or anything you want.
 * For this example we use included FileTokenRepository
 */
$tokenRepository = new FileTokenRepository(__DIR__ . '/var/immi_token.json');

if (!$tokenRepository->load()) {
    $tokenRepository->save($client->oauth()->fetchTokenWithClientCredentials());
}

//this plugin will take care of refreshing expired access tokens and will store new ones with $tokenRepository
$client->addPlugin(new AuthPlugin($tokenRepository, $client->oauth()));
//optional, this plugin will throw exceptions on every negative http status code
$client->addPlugin(new ErrorPlugin());

$response = $client->users()->me()->get();

dump(json_decode($response->getBody()->__toString(), true));
```

### Auth code flow
If you want to use it, please contact me to get detailed info.

### Resources
You can use client instantiated in auth part.

From now you can use these methods on $client:

```php
use Imper86\ImmiApi\Immi;
$client->api()->(...)
$client->attributes()->(...)
$client->carts()->(...)
$client->commands()->(...)
$client->contactRequests()->(...)
$client->countries()->(...)
$client->orders()->(...)
$client->products()->(...)
$client->users()->(...)
```

If you use IDE with typehinting such as PHPStorm, you'll easily 
figure it out. If not, please 
[take a look in Resource directory](src/Resource)

**Be aware than not all resources will be accessible for you. 
Many of them requires admin role, because the API is 
shared between admin users and client users.**

## Contributing
Any help will be very appreciated.
