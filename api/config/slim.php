<?php

$config['slim'] = [
    'displayErrorDetails' => env('ENV', 'development') === 'development' ? true : false,
    'addContentLengthHeader' => true,
];
