<?php

namespace OAuth2;

class User
{
    private string $id;
    private string $login;

    public function __construct(string $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }
}