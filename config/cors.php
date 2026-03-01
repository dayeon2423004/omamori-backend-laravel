<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // 'allowed_origins' => [
    //     'https://omamori-frontend-react.vercel.app',
    //     'https://omamori-frontend-react-pudabk9dq-dayeon2423004s-projects.vercel.app',
    //     'http://localhost:3000',
    //     'http://localhost:5173',
    // ],
    
    // 'allowed_origins_patterns' => [
    // '#^https://omamori-frontend-react-.*\.vercel\.app$#', // 이 패턴이 모든 vercel 프리뷰 주소를 잡아줍니다.
    // ],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
