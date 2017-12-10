<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Message;
use Interop\Container\ContainerInterface;

class Dummy extends Swift
{

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container['app.settings']['mail']['providers']['dummy'];
        $this->transport = Swift_SmtpTransport::newInstance($this->config['server'], $this->config['port'])
          ->setUsername($this->config['user'])
          ->setPassword($this->config['password']);
        $this->swift = Swift_Mailer::newInstance($this->transport);
    }
    
    public function prepareMail(array $data)
    {
        $formatedData = [
                    'from'    => $this->config['from'],
                    'to'      => $this->config['dummymail'],
                    'subject' => isset($data['subject'])?$data['subject']:'',
                    'text'    => isset($data['text'])?$data['text']:'',
                    'html'    => isset($data['html'])?$data['html']:'',
                ];
        $this->to = is_string($formatedData['to'])?[$formatedData['to']]:$formatedData['to'];
        $this->message = Swift_Message::newInstance($formatedData['subject'])
          ->setFrom($formatedData['from'])
          ->setBody($formatedData['html'], 'text/html')
          ->addPart($formatedData['text']);
        return $this;
    }
}
