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
        'state' => 'DEAZFAEF321432DAEAFD3E13223R',
        'auth_link' => 'http://localhost:7070/auth?response_type=code&client_id={CLIENT_ID}&state={STATE}&scope=email&redirect_uri={SUCCESS_URL}',
        'callback_link' => 'http://oauth-server/token?grant_type=authorization_code&code={CODE}&client_id={CLIENT_ID}&client_secret={CLIENT_SECRET}',
        'me_link' => 'http://oauth-server/me',
    ],
];