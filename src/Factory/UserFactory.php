<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PasswordService;
use App\Service\TokenService;

class UserFactory
{
    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * @var TokenService
     */
    private $tokenService;

    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * UserFactory constructor.
     * @param PasswordService $passwordService
     * @param TokenService $tokenService
     * @param UserRepository $userRepo
     */
    public function __construct(
        PasswordService $passwordService,
        TokenService $tokenService,
        UserRepository $userRepo
    ){
        $this->passwordService = $passwordService;
        $this->tokenService = $tokenService;
        $this->userRepo = $userRepo;
    }

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $hash = $this->passwordService->password_generate($data['password']);
        $token = $this->tokenService->generate(24);

        $user = new User(
            $data['name'],
            $data['email'],
            $data['role'],
            $hash,
            $token
        );

        $this->userRepo->save($user, true);

        return $user;
    }
}
