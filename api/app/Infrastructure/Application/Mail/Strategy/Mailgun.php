<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

use Http\Adapter\Guzzle6\Client;
use Mailgun\Mailgun as ParentMailgun;
use Interop\Container\ContainerInterface;

class Mailgun implements MailerStrategyInterface
{
    protected $mailgun;

    protected $domain;

    protected $message;

    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container['app.settings']['mail']['providers']['mailgun'];
        $client = new Client();
        $this->domain = $this->config['domain'];
        $this->mailgun = new ParentMailgun($this->config['api_key'], $client);
    }

    public function send()
    {
        $result = $this->mailgun->sendMessage("$this->domain", $this->message);
    }

    public function prepareMail(array $data)
    {
        $this->message = [
                    'from'    => $this->config['from'],
                    'to'      => isset($data['to'])?$data['to']:'',
                    'subject' => isset($data['subject'])?$data['subject']:'',
                    'text'    => isset($data['text'])?$data['text']:'',
                    'html'    => isset($data['html'])?$data['html']:'',
                ];
        return $this;
    }
}
