<?php

namespace OAuth2\Providers;

use OAuth2\User;

abstract  class Provider
{
    protected string $providerName;

    protected string $clientID;

    protected string $clientSecret;

    protected string $state;

    protected string $localUrl;

    protected string $authLink;

    protected string $callbackLink;

    protected string $meLink;

    public function __construct(string $providerName, string $clientID, string $clientSecret, string $state, string $authLink, string $callbackLink, string $meLink, string $localUrl)
    {
        $this->providerName = $providerName;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->state = $state;
        $this->localUrl = $localUrl;
        $this->callbackLink = $callbackLink;
        $this->meLink = $meLink;

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

    public function getUser(): ?User
    {
        $userInformationsArray = $this->getUserInformations();

        if ([] === $userInformationsArray)
            return null;

        return new User($userInformationsArray);
    }

    abstract protected function getUserInformations(): array;

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
        $this->callbackLink = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }
}