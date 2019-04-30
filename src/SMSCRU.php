<?php

namespace DenisKisel\SMSCRU;

use DenisKisel\SMSCRU\Exceptions\SMSCRUException;
use Illuminate\Contracts\Notifications\Dispatcher;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class SMSCRU
 * @package DenisKisel\SMSCRU
 *
 * @method login
 * @method pass
 * @method sender
 * @method charset
 * @method message
 * @method phone
 *
 * @method logger LoggerInterface
 */
class SMSCRU
{
    protected $url = 'https://smsc.ru/sys/send.php';
    protected $login = '';
    protected $pass = '';
    protected $sender = '';
    protected $charset = 'utf-8';
    protected $message = '';
    protected $phone = '';

    protected $logger = null;

    public function __construct()
    {
        $this->login = config('smscru.login');
        $this->pass = config('smscru.pass');
        $this->sender = config('smscru.sender');
        $this->charset = config('smscru.charset');
        $this->logger = new Logger('smscru.log');
    }

    public function send($phone = null, $message = null, $isLogger = false, $logLevel = 'debug')
    {
        $phone = (is_null($phone)) ? $this->phone : $phone;
        $message = (is_null($message)) ? $this->message : $message;

        $data = [
            'login' => $this->login,
            'psw' => $this->pass,
            'phones' => $phone,
            'mes' => $message,
            'sender' => $this->sender,
            'charset' => $this->charset
        ];
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($isLogger) {
            $this->logger->{$logLevel}('SMSCRU', [$response]);
        }

        return $response;
    }

    public function __call($name, $arguments) {
        $vars = get_class_vars(__CLASS__);
        if (in_array($name, $vars)) {
            $this->{$name} = array_shift($arguments);
            return $this;
        } else {
            throw new SMSCRUException('Method is not exists in the SMSCRU class. File:' . __FILE__ . ' Line:' . __LINE__);
        }
    }

    public function logger(LoggerInterface $logger)
    {
        $this->logger = null;
        $this->logger = $logger;
        return $this;
    }
}
