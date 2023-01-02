<?php
declare(strict_types=1);
namespace User;

class User{
    public string $username;
    public string $password;
    public string $role;

    public function __construct(string $username = '', string $password = '', string $role = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->role     = $role;
    }
}