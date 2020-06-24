<?php

namespace OAuth2\Providers;

abstract  class Provider
{
    protected string $providerName;

    protected string $clientID;

    protected string $clientSecret;

    protected string $state;

    protected string $localUrl;

    protected string $authLink;

    public function __construct(string $providerName, string $clientID, string $clientSecret, string $state, string $authLink, string $callbackLink, string $localUrl)
    {
        $this->providerName = $providerName;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->state = $state;
        $this->localUrl = $localUrl;

        $this->setAuthLink($authLink);
    }

    public function getAuthLink(): string
    {
        return $this->authLink;
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }

    protected function setAuthLink(string $link): Provider
    {
        $link = preg_replace('/\{SUCCESS_URL\}/', $this->localUrl . '/success/' . $this->providerName, $link);
        $link = preg_replace('/\{STATE\}/', $this->state, $link);
        $this->authLink = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }
}