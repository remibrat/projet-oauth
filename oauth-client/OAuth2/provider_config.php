<?php

use OAuth2\Providers\FacebookProvider;
use OAuth2\Providers\GithubProvider;
use OAuth2\Providers\OAuthProvider;

return [
    'facebook' => [
        'class_name' => FacebookProvider::class,
        'client_id' => '2730184057200873',
        'client_secret' => 'a99b6a4c5f05a5377a6062449e8a488d',
    ],
    'github' => [
        'class_name' => GithubProvider::class,
        'client_id' => '717e00701186170e2f6a',
        'client_secret' => '593be6871baebfb99c8763aa99f9077f92a7aed0',
    ],
    'oauth' => [
        'class_name' => OAuthProvider::class,
        'client_id' => 'client_5ef37f10e42cf8.67246672',
        'client_secret' => 'ad67ccac33fb8731ea84378f58035bd8d76b4cfb',
    ],
];
