<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. The minimum
    | required options are declared here, but the full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */
    'credentials' => [
        'key'    => env('AKIAIETXGEOQ6Y26M6SQ'),
        'secret' => env('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'),
    ],
    'region' => env('AWS_REGION', 'us-west-2'),
    'version' => 'latest',

];
