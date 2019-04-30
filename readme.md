# SMSCRU

Пакет для работы с api [smsc.ru](https://smsc.ru/)

## Installation

Via Composer

``` bash
$ composer require denis-kisel/smscru-laravel
```

## Settings

Публикуем вендор
``` bash
$  php artisan vendor:publish --provider="DenisKisel\\SMSCRU\\SMSCRUServiceProvider"
```

Указываем логин и пароль в файле конфига configs/smscru.php
``` php
<?php

return [
    'login' => env('SMSC_LOGIN', 'your-login'),
    'pass' => env('SMSC_PASS', 'your-pass'),
    'sender' => env('SMSC_SENDER', 'sender'),
    'charset' => env('SMSC_CHARSET', 'utf-8'),
];
```

Добавляем по желанию фасад в фаил configs/app.php
``` php
<?php
...
'aliases' => [
        ...
        'SMSCRU' => \DenisKisel\SMSCRU\Facades\SMSCRU::class,
    ],
```

## Usage
``` php
<?php
...
$sms = new SMSCRU();
$sms->send($phone, $message);

//Или через фасад
SMSCRU::send($phone, $message);

//Или так
SMSCRU::phone($phone)
    ->message($message)
    ->send();

//Доступные методы
$sms->login($login)
    ->pass($pass)
    ->sender($sender)
    ->charset($charset)
    ->phone($phone)
    ->message($message)
    ->send()
    

    
//Логирование. По умолчанию используется Monolog\Logger с уровнем записи debug
$sms->send($phone, $message, true);

//Можно заменить логер на другой с интерфейсом LoggerInterface
$sms->logger(new DBLog())->send($phone, $message, true);

//Можно заменить уровень записи на доступный из интерфейса LoggerInterface
$sms->logger(new DBLog())->send($phone, $message, true, 'info');
```
