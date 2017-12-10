<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Message;
use Interop\Container\ContainerInterface;

class Mailtrap implements MailerStrategyInterface
{
    protected $swift;

    protected $transport;

    protected $message;

    protected $config;

    protected $to;

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container['app.settings']['mail']['providers']['mailtrap'];

        $this->transport = (new Swift_SmtpTransport($this->config['server'], $this->config['port']))
            ->setUsername($this->config['user'])
            ->setPassword($this->config['password']);
        $this->swift = new Swift_Mailer($this->transport);
    }

    public function send()
    {
        $numSent = 0;
        $to = $this->to;

        foreach ($to as $address => $name) {
            if (is_int($address)) {
                $this->message->setTo($name);
            } else {
                $this->message->setTo([$address => $name]);
            }

            $numSent += $this->swift->send($this->message);
        }
    }

    public function prepareMail(array $data)
    {
        $formatedData = [
                    'from'    => $this->config['from'],
                    'to'      => isset($data['to'])?$data['to']:'',
                    'subject' => isset($data['subject'])?$data['subject']:'',
                    'text'    => isset($data['text'])?$data['text']:'',
                    'html'    => isset($data['html'])?$data['html']:'',
                ];
        $this->to = is_string($formatedData['to'])?[$formatedData['to']]:$formatedData['to'];
        $this->message = (new Swift_Message($formatedData['subject']))
          ->setFrom($formatedData['from'])
          ->setBody($formatedData['html'], 'text/html')
          ->addPart($formatedData['text']);
        return $this;
    }
}
