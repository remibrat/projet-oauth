<?php

namespace OAuth2;

use OAuth2\Providers\Provider;

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

    public function getProvider(string $providerName): ?Provider
    {
        foreach ($this->providers as $provider)
            if ($provider->getProviderName() === $providerName)
                return $provider;

        return null;
    }

    protected function loadProviders($localUrl): void
    {
        if (! file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'provider_config.php'))
            throw new \Exception('Le fichier provider_config est introuvable.');

        $providersArray = include __DIR__ . DIRECTORY_SEPARATOR . 'provider_config.php';

        $this->providers = array_map(function (string $providerName, array $providerArray) use ($localUrl) {
            return new $providerArray['class_name'](
                $providerName,
                $providerArray['client_id'],
                $providerArray['client_secret'],
                $localUrl,
            );
        }, array_keys($providersArray), $providersArray);
    }
}