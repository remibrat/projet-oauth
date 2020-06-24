<?php

use OAuth2\Providers\FacebookProvider;
use OAuth2\Providers\GithubProvider;
use OAuth2\Providers\OAuthProvider;

return [
//    'facebook' => [
//        'class_name' => FacebookProvider::class,
//        'client_id' => '',
//        'client_secret' => '',
//        'link' => '',
//        'state' => '',
//    ],
//    'github' => [
//        'class_name' => GithubProvider::class,
//        'client_id' => '',
//        'client_secret' => '',
//        'link' => '',
//        'state' => '',
//    ],
    'oauth' => [
        'class_name' => OAuthProvider::class,
        'client_id' => 'client_5edfd43b0db573.88203718',
        'client_secret' => 'e0a6a1f5c55fafd48cbcce2b7279d4029fad76f4',
        'link' => 'http://localhost:7070/auth?response_type=code&client_id={CLIENT_ID}&state={STATE}&scope=email&redirect_uri={LOCAL_URL}/success',
        'state' => 'DEAZFAEF321432DAEAFD3E13223R',
    ],
];