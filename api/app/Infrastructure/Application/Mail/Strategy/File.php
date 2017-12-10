<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

use Interop\Container\ContainerInterface;

class File implements MailerStrategyInterface
{
    protected $path;

    protected $message;

    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $name = $container['app.settings']['mail']['default'];
        $this->config   = $container['settings']['mail']['providers'][$name];
        $this->path     = ROOT_PATH.'/storage/mail/';
    }

    public function send()
    {
        $file = $this->path . $this->generateMessageFileName();
        try {
            $result = file_put_contents($file, $this->message);
        } catch (\Exception $e) {
            $result = false;
        }
        return $result;
    }

    public function prepareMail(array $data)
    {
        $sender = $this->config['from'];
        if (is_array($this->config['from'])) {
            $email = array_keys($this->config['from']);
            $name = array_values($this->config['from']);
            $sender = $name[0].' <'.$email[0].'>';
        }
        $from       = $sender;
        $to         = isset($data['to'])?$data['to']:'';
        $subject    = isset($data['subject'])?$data['subject']:'';
        $text       = isset($data['text'])?$data['text']:'';
        $html       = isset($data['html'])?$data['html']:'';
        $message = <<<EOT
From: $from
MIME-Version: 1.0
To: $to
Subject: $subject
Content-Type: multipart/mixed; boundary="080107000800000609090108"

This is a message with multiple parts in MIME format.
--080107000800000609090108
Content-Type: text/html

$html
--080107000800000609090108
Content-Type: text/plain

$text
--080107000800000609090108
EOT;
        $this->message = $message;
        
        return $this;
    }

    /**
     * @return string the file name for saving the message.
     */
    protected function generateMessageFileName()
    {
        $time = microtime(true);
        return date('Ymd-His-', $time) . sprintf('%04d', (int) (($time - (int) $time) * 10000)) . '-' . sprintf('%04d', mt_rand(0, 10000)) . '.eml';
    }
}
