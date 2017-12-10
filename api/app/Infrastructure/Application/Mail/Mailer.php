<?php

namespace Intergift\Infrastructure\Application\Mail;

use Interop\Container\ContainerInterface;

class Mailer
{
    /**
     * @var MailerStrategyInterface $mailer
     */
    protected $mailer;

    /**
     * @var Faso\Environment $env
     */
    protected $env;

    /**
     * @var Interop\Container\ContainerInterface $container
     */
    protected $container;

    /**
     * The view engine
     */
    protected $view;

    /**
     * @var Array $config
     */
    protected $config;
    /**
     * @var Array $data
     */
    protected $data = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $this->container->get('app.settings')['mail'];
        $name = $this->getMailerName();
        $mailer = new $name($this->container);
        $this->setMailer($mailer);
    }

    public function setTo($to)
    {
        $this->data['to'] = $to;
        return $this;
    }
    
    public function setBody($body)
    {
        $this->data['html'] = $body;
        return $this;
    }

    public function setText($text)
    {
        $this->data['text'] = $text;
        return $this;
    }
    public function setSubject($subject)
    {
        $this->data['subject'] = $subject;
        return $this;
    }

    public function send()
    {
        $this->mailer->prepareMail($this->data)->send();

        $this->setBody(null)->setText(null);
    }

    public function setEnvironment($env)
    {
        if ('development' == $env) {
            $this->config['test']['active'] = true;
            $name = $this->getMailerName();
            $mailer = new $name($this->container);
            $this->setMailer($mailer);
        }
        return $this;
    }

    protected function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }

    protected function getMailer()
    {
        $this->mailer;
    }

    protected function getMailerName()
    {
        if (true === (bool) $this->config['test']['active']) {
            return __NAMESPACE__.'\Strategy'.'\\'.ucfirst($this->config['test']['transport']);
        }
        return __NAMESPACE__.'\Strategy'.'\\'.ucfirst($this->config['default']);
    }
}
