<?php

namespace App\Factory;

use App\Entity\Api_User;
use App\Entity\Login;
use App\Repository\ApiUserRepository;
use App\Repository\LoginRepository;
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
     * @var ApiUserRepository
     */
    private $userRepo;
    /**
     * @var LoginRepository
     */
    private $loginRepo;

    /**
     * UserFactory constructor.
     * @param PasswordService $passwordService
     * @param TokenService $tokenService
     * @param ApiUserRepository $userRepo
     * @param LoginRepository $loginRepo
     */
    public function __construct(
        PasswordService $passwordService,
        TokenService $tokenService,
        ApiUserRepository $userRepo,
        LoginRepository $loginRepo
    ){
        $this->passwordService = $passwordService;
        $this->tokenService = $tokenService;
        $this->userRepo = $userRepo;
        $this->loginRepo = $loginRepo;
    }

    /**
     * @param array $data
     * @return Api_User
     * @throws \Exception
     */
    public function createUser(array $data)
    {
        $hash = $this->passwordService->password_generate($data['password']);
        $token = $this->tokenService->generate(24);

        $user = new Api_User(
            $data['name'],
            $data['email'],
            $data['role'],
            $hash,
            $token
        );

        $this->userRepo->save($user, true);

        $lastLogin = new Login($user);
        $this->loginRepo->save($lastLogin, true);

        $user->setLastLogin($lastLogin);
        $this->userRepo->save($user, false);

        return $user;
    }
}
