<?php

namespace OAuth2\Providers;

abstract  class Provider
{
    protected string $providerName;

    protected string $clientID;

    protected string $clientSecret;

    protected string $state;

    protected string $localUrl;

    protected string $link;

    public function __construct(string $providerName, string $clientID, string $clientSecret, string $state, string $link, string $localUrl)
    {
        $this->providerName = $providerName;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->state = $state;
        $this->localUrl = $localUrl;

        $this->setLink($link);
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }

    protected function setLink(string $link): Provider
    {
        $link = preg_replace('/\{SUCCESS_URL\}/', $this->localUrl . '/success/' . $this->providerName, $link);
        $link = preg_replace('/\{STATE\}/', $this->state, $link);
        $this->link = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }
}