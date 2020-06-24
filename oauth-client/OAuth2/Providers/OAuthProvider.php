<?php

namespace OAuth2\Providers;

class OAuthProvider extends Provider
{
    protected function getUserInformations(): array
    {
        //TODO : Faire un truc plus propre
        ['code' => $this->code, 'state' => $rstate] = $_GET;

        if ($rstate !== $this->state)
            return [];

        $this->setCallbackLink();

        ['token' => $token] = json_decode(file_get_contents($this->callbackLink), true);

        // Get user data
        $link = "http://oauth-server/me";
        $rs = curl_init($this->meLink);
        curl_setopt_array($rs, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$token}"
            ]
        ]);
        $userInformationsArray = json_decode(curl_exec($rs), JSON_OBJECT_AS_ARRAY);
        curl_close($rs);

        return $userInformationsArray;
    }
}