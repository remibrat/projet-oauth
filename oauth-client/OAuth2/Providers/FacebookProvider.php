<?php

namespace OAuth2\Providers;

class FacebookProvider extends Provider
{
    protected function mapUserInformations(array $userInformations): array
    {
        return [
            'id' => $userInformations['id'],
            'login' => $userInformations['name']
        ];
    }

    protected function getToken(): ?string
    {
        ['code' => $this->code, 'state' => $returnedState] = $_GET;

        if ($returnedState !== $this->state)
            return null;

        $this->setCallbackLink();

        $ch = curl_init($this->callbackLink);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);

        ['access_token' => $token] = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $token;
    }

    protected function getAuthLink(): string
    {
        return 'https://www.facebook.com/v7.0/dialog/oauth?client_id={CLIENT_ID}&redirect_uri={SUCCESS_URL}&state={STATE}';
    }

    protected function getCallbackLink(): string
    {
        return 'https://graph.facebook.com/v7.0/oauth/access_token?client_id={CLIENT_ID}&redirect_uri={SUCCESS_URL}&client_secret={CLIENT_SECRET}&code={CODE}';
    }

    protected function getMeLink(): string
    {
        return 'https://graph.facebook.com/me?fields=name,email,id';
    }
}