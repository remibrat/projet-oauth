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
        'client_id' => 'client_5ef37f10e42cf8.67246672',
        'client_secret' => 'ad67ccac33fb8731ea84378f58035bd8d76b4cfb',
        'link' => 'http://localhost:7070/auth?response_type=code&client_id={CLIENT_ID}&state={STATE}&scope=email&redirect_uri={SUCCESS_URL}',
        'state' => 'DEAZFAEF321432DAEAFD3E13223R',
    ],
];