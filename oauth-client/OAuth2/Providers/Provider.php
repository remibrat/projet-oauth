<?php

namespace OAuth2\Providers;

abstract  class Provider
{
    protected string $clientID;

    protected string $clientSecret;

    protected string $state;

    protected string $localUrl;

    protected string $link = 'dd';

    public function __construct($clientID, $clientSecret, $state, $link, $localUrl)
    {
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

    protected function setLink(string $link): Provider
    {
        $link = preg_replace('/\{LOCAL_URL\}/', $this->localUrl, $link);
        $link = preg_replace('/\{STATE\}/', $this->clientSecret, $link);
        $this->link = preg_replace('/\{CLIENT_ID\}/', $this->clientID, $link);

        return $this;
    }
}