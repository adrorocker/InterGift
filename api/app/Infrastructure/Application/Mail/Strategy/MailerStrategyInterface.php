<?php

namespace Intergift\Infrastructure\Application\Mail\Strategy;

interface MailerStrategyInterface
{
    /**
     * Send email
     */
    public function send();

    /**
     * Prepare mail data
     */
    public function prepareMail(array $data);
}
