<?php

namespace OAuth2\Providers;

use OAuth2\User;

abstract  class Provider
{
    protected string $providerName;

    protected string $clientID;

    protected string $clientSecret;

    protected string $state = 'DEAZFAEF321432DAEAFD3E13223R';

    protected string $localUrl;

    protected string $authLink;

    protected string $callbackLink;

    protected string $meLink;

    public function __construct(string $providerName, string $clientID, string $clientSecret, string $localUrl)
    {
        $this->providerName = $providerName;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->localUrl = $localUrl;

        $this->callbackLink = $this->getCallbackLink();
        $this->meLink = $this->getMeLink();
        $this->setAuthLink($this->getAuthLink());
    }

    public function getMappedAuthLink(): string
    {
        return $this->authLink;
    }


    public function getProviderName(): string
    {
        return $this->providerName;
    }

    public function getUser(): ?User
    {
        $token = $this->getToken();

        if (null === $token)
            throw new \Exception('Impossible de récupérer le token.');

        $userInformationsArray = $this->getUserInformations($token);

        if ([] === $userInformationsArray)
            return null;

        return new User($userInformationsArray['id'], $userInformationsArray['login']);
    }

    abstract protected function mapUserInformations(array $userInformations): array;

    protected function setAuthLink(string $link): Provider
    {
        $link = preg_replace('/\{SUCCESS_URL\}/', $this->localUrl . '/success/' . $this->providerName, $link);
        $link = preg_replace('/\{STATE\}/', $this->state, $link);
        $this->authLink = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }

    protected function setCallbackLink(): Provider
    {
        $link = preg_replace('/\{CODE\}/', $this->code, $this->callbackLink);
        $link = preg_replace('/\{CLIENT_SECRET\}/', $this->clientSecret, $link);
        $link = preg_replace('/\{SUCCESS_URL\}/', $this->localUrl . '/success/' . $this->providerName, $link);
        $link = preg_replace('/\{STATE\}/', $this->state, $link);
        $this->callbackLink = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }

    protected function getToken(): ?string
    {
        ['code' => $this->code, 'state' => $returnedState] = $_GET;

        if ($returnedState !== $this->state)
            return null;

        $this->setCallbackLink();

        ['token' => $token] = json_decode(file_get_contents($this->callbackLink), true);

        return $token;
    }

    protected function getUserInformations(string $token): array
    {
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

        return $this->mapUserInformations($userInformationsArray);
    }

    protected abstract function getAuthLink(): string;

    protected abstract function getCallbackLink(): string;

    protected abstract function getMeLink(): string;
}
