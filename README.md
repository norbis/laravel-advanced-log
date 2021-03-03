# Advanced Laravel LogManager
Extended LogManager with additional Monolog drivers

## Installation
```shell
composer require norbis/laravel-advanced-log
```

## Telegram channel
Define Telegram Bot Token and chat id (users telegram id) and set as environment parameters.
Add to <b>.env</b>
```
TELEGRAM_BOT_APIKEY=id:token
TELEGRAM_BOT_CHAT_ID=chat_id
```
```php
'telegram' => [
    'driver' => 'telegram',
    'apiKey' => env('TELEGRAM_BOT_APIKEY'),
    'channel' => env('TELEGRAM_BOT_CHAT_ID'),
    //default debug
    'level'  => 'debug',
    //default true
    'bubble' => true,
    //default HTML
    'parseMode' => 'HTML',
    //default false
    'disableWebPagePreview' => false,
    //default false
    'disableNotification' => false,
],
```