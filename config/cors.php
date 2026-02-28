// config/cors.php
<?php

'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

// 바로 이 부분을 수정하세요!
'allowed_origins' => [
    'https://omamori-frontend-react.vercel.app', // Vercel 주소 추가
    'http://localhost:3000',                     // 로컬 개발용 (필요시)
    'http://localhost:5173',                     // Vite 로컬용 (필요시)
],

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => [],

'max_age' => 0,

'supports_credentials' => true, // 쿠키/세션 사용 시 true 필수
