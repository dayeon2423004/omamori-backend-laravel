<?PHP

return [

    'paths' => [
        'api/*',
        'assets/*', 
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://omamori-frontend-react.vercel.app',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];