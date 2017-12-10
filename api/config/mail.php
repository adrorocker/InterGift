<?php
/**
 * Test providers : file, mailtrap, dummy
 */
$config['mail'] = [
    'default'       => env('MAILER.PROVIDER', 'sendgrid'),
    'test'          => [
        'active'    => env('MAILER_TEST.ACTIVE', false),
        'transport' => env('MAILER_TEST.TRANSPORT', 'mailtrap'),
    ],
    'providers'     => [
        'mailgun'   => [
            'api_key'   => env('MAILGUN.APY_KEY', ''),
            'domain'    => env('MAILGUN.DOMAIN', ''),
            'from'      => env('MAILGUN.USER', ''),
        ],
        'sendgrid'  => [
            'api_key'   => env('SENDGRID.APY_KEY', ''),
            'from'      => [env('SUPPORT_EMAIL', '') => 'InterGift'],
        ],
        'mailtrap'  => [
            'server'    => 'smtp.mailtrap.io',
            'port'      => env('MAILTRAP.PORT', 2525),
            'from'      => [env('SUPPORT_EMAIL', '') => 'InterGift'],
            'user'      => env('MAILTRAP.USER', ''),
            'password'  => env('MAILTRAP.PASS', ''),
            'dummymail' => env('MAILTRAP.EMAIL', '')
        ],
        'swift'     => [
            'server'    => env('SMTP.SERVER', ''),
            'port'      => env('SMTP.PORT', 25),
            'from'      => [env('SUPPORT_EMAIL', '') => 'InterGift'],
            'user'      => env('SMTP.USER', ''),
            'password'  => env('SMTP.PASSWORD', ''),
        ],
        'file'     => [
            'from'      => [env('SUPPORT_EMAIL', '') => 'InterGift'],
        ],
    ],
];
