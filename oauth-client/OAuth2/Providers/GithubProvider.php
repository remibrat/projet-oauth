<?php

namespace OAuth2\Providers;

class GithubProvider extends Provider
{
    protected function mapUserInformations(array $userInformations): array
    {
        return [
            'id' => $userInformations['id'],
            'login' => $userInformations['login']
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
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);

        ['access_token' => $token] = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $token;
    }

    protected function getUserInformations(string $token): array
    {
        $rs = curl_init($this->meLink);

        curl_setopt_array($rs, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => [
                'Authorization: token ' . $token,
                'Accept: application/json',
                'User-Agent: taoberquer',
            ]
        ]);
        $userInformationsArray = json_decode(curl_exec($rs), JSON_OBJECT_AS_ARRAY);
        curl_close($rs);

        return $this->mapUserInformations($userInformationsArray);
    }

    protected function getAuthLink(): string
    {
        return 'https://github.com/login/oauth/authorize?client_id={CLIENT_ID}&state={STATE}&scope=email&redirect_uri={SUCCESS_URL}';
    }

    protected function getCallbackLink(): string
    {
        return 'https://github.com/login/oauth/access_token?code={CODE}&client_id={CLIENT_ID}&client_secret={CLIENT_SECRET}&redirect_uri={SUCCESS_URL}&state={STATE}';
    }

    protected function getMeLink(): string
    {
        return 'https://api.github.com/user';
    }
}