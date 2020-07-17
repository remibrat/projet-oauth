<?php

namespace OAuth2\Providers;

class OAuthProvider extends Provider
{
    protected function mapUserInformations(array $userInformations): array
    {
        return [
            'id' => $userInformations['user_id'],
            'login' => $userInformations['email']
        ];
    }

    protected function getAuthLink(): string
    {
        return 'http://localhost:7070/auth?response_type=code&client_id={CLIENT_ID}&state={STATE}&scope=email&redirect_uri={SUCCESS_URL}';
    }

    protected function getCallbackLink(): string
    {
        return 'http://oauth-server/token?grant_type=authorization_code&code={CODE}&client_id={CLIENT_ID}&client_secret={CLIENT_SECRET}';
    }

    protected function getMeLink(): string
    {
        return 'http://oauth-server/me';
    }
}