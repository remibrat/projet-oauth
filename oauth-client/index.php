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
    global $STATE;
    global $CLIENT_ID;
    global $CLIENT_SECRET;
    ['code' => $code, 'state' => $rstate] = $_GET;

    // Check state origin
    if ($STATE === $rstate) {
        // Get access token
        $link = "http://oauth-server/token?grant_type=authorization_code&code={$code}&client_id={$CLIENT_ID}&client_secret={$CLIENT_SECRET}";
        ['token' => $token] = json_decode(file_get_contents($link), true);

        // Get user data
        $link = "http://oauth-server/me";
        $rs = curl_init($link);
        curl_setopt_array($rs, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}"
            ]
        ]);
        echo curl_exec($rs);
        curl_close($rs);
    } else {
        http_response_code(400);
        echo "Invalid state";
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
