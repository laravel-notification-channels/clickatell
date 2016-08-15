# Clickatell notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/clickatell.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/clickatell)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/clickatell/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/clickatell)
[![StyleCI](https://styleci.io/repos/65379321/shield)](https://styleci.io/repos/65379321)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/9015691f-130d-4fca-8710-72a010abc684.svg?style=flat-square)](https://insight.sensiolabs.com/projects/9015691f-130d-4fca-8710-72a010abc684)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/clickatell.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/clickatell)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/clickatell.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/clickatell)


This package makes it easy to send notifications using [clickatell.com](https://www.clickatell.com/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the Clickatell service](#setting-up-the-clickatell-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

```bash
composer require laravel-notification-channels/clickatell
```

You must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Clickatell\ClickatellServiceProvider::class,
],
```

### Setting up the clickatell service

Add your Clickatell user, password and api identifier  to your `config/services.php`:

```php
// config/services.php
...
'clickatell' => [
    'user'  => env('CLICKATELL_USER'),
    'pass' => env('CLICKATELL_PASS'),
    'api_id' => env('CLICKATELL_API_ID'),
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Clickatell\ClickatellMessage;
use NotificationChannels\Clickatell\ClickatellChannel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [ClickatellChannel::class];
    }

    public function toClickatell($notifiable)
    {
        return (new ClickatellMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

### Available methods

TODO

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing
    
``` bash
$ composer test
```

## Security

If you discover any security related issues, please email hello@etiennemarais.co.za instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [etiennemarais](https://github.com/etiennemarais)
- [arcturial](https://github.com/arcturial)
    - For the [Clickatell Client implementation](https://github.com/arcturial/clickatell) which I leverage on for this wrapper

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
