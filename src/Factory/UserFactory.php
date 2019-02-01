<?php

namespace App\Factory;

use App\Entity\User;
use App\Service\PasswordService;

class UserFactory
{
    private $passwordService;

    public function __construct(
        PasswordService $passwordService
    ){
        $this->passwordService = $passwordService;
    }

    public function createUser(array $data)
    {
        $salt = $this->passwordService->salt_generate();
        $hash = $this->passwordService->password_generate($salt, $data['password']);
        $user = new User(
            $data['name'],
            $data['email'],
            $salt,
            $hash
        );

        return $user;
    }
}
