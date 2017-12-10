<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

use Interop\Container\ContainerInterface;
use SendGrid\Email;
use SendGrid\Content;
use SendGrid\Mail;
use \SendGrid as ParentSendgrid;

class Sendgrid implements MailerStrategyInterface
{
    protected $sendgrid;

    protected $message;

    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container['app.settings']['mail']['providers']['sendgrid'];
        $this->sendgrid = new ParentSendgrid($this->config['api_key']);
    }

    public function send()
    {
        $response = $this->sendgrid->client->mail()->send()->post($this->message);
    }

    public function prepareMail(array $data)
    {

        $email = array_keys($this->config['from']);
        $name = array_values($this->config['from']);

        $this->message = new Mail(
            new Email($name[0], $email[0]),
            $data['subject'],
            new Email('', $data['to']),
            new Content("text/html", $data['html'])
        );
        return $this;
    }
}
