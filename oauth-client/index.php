<?php

use OAuth2\OAuth2SDK;

$CLIENT_ID = "client_5ef37f10e42cf8.67246672";
$CLIENT_SECRET = "ad67ccac33fb8731ea84378f58035bd8d76b4cfb";
$STATE = "DEAZFAEF321432DAEAFD3E13223R";
$LOCAL_URL = "http://localhost:7071";

spl_autoload_register(function ($className) {
    $className = __DIR__ . DIRECTORY_SEPARATOR . preg_replace(
        '/\\\\/',
        DIRECTORY_SEPARATOR,
        preg_replace('/^OAuth2/', 'OAuth2', $className)
    ) . '.php';

    if (! file_exists($className))
        throw new Exception('Imposible d\'inclure la class : ' . $className);

    include $className;
});

function home()
{
    $oAuth2SDK =  new OAuth2SDK('http://localhost:7071');

    foreach ($oAuth2SDK->getProviders() as $provider)
        echo '<a href="' . $provider->getAuthLink() . '">Se connecter via ' . $provider->getProviderName() . '</a>';
}

function callback(string $providerName)
{
    $oAuth2SDK =  new OAuth2SDK('http://localhost:7071');

    $provider = $oAuth2SDK->getProvider($providerName);

    $user = $provider->getUser();

    if (null === $user) {
        http_response_code(400);
        echo "Invalid state";
    } else {
        var_dump($user);
    }
}

// Router
$route = strtok($_SERVER['REQUEST_URI'], '?');
switch ($route) {
    case '/':
        home();
        break;
    case '/success/oauth':
        callback('oauth');
        break;
}
