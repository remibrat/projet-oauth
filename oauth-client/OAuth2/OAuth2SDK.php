<?php

namespace OAuth2;

class OAuth2SDK
{
    protected array $providers;

    public function __construct(string $localUrl)
    {
        $this->loadProviders($localUrl);
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    protected function loadProviders($localUrl): void
    {
        if (! file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'provider_config.php'))
            throw new \Exception('Le fichier provider_config est introuvable.');

        $providersArray = include __DIR__ . DIRECTORY_SEPARATOR . 'provider_config.php';

        $this->providers = array_map(function ($providerArray) use ($localUrl) {
            return new $providerArray['class_name'](
                $providerArray['client_id'],
                $providerArray['client_secret'],
                $providerArray['state'],
                $providerArray['link'],
                $localUrl,
            );
        }, $providersArray);
    }
}