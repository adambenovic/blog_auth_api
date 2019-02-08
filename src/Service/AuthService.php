<?php

namespace App\Service;

use App\Factory\LoginFactory;
use App\Repository\LoginRepository;
use App\Repository\ApiUserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthService
{
    /**
     * @var ApiUserRepository
     */
    private $userRepo;

    /**
     * @var TokenService
     */
    private $tokenGenerator;

    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var LoginFactory
     */
    private $loginFactory;

    /**
     * @var LoginRepository
     */
    private $loginRepo;

    /**
     * AuthService constructor.
     * @param ContainerInterface $container
     * @param ApiUserRepository $userRepo
     * @param TokenService $tokenService
     * @param PasswordService $passwordService
     * @param LoginFactory $loginFactory
     * @param LoginRepository $loginRepo
     */
    public function __construct(
        ContainerInterface $container,
        ApiUserRepository $userRepo,
        TokenService $tokenService,
        PasswordService $passwordService,
        LoginFactory $loginFactory,
        LoginRepository $loginRepo
    ){
        $this->container = $container;
        $this->userRepo = $userRepo;
        $this->tokenGenerator = $tokenService;
        $this->passwordService = $passwordService;
        $this->loginFactory = $loginFactory;
        $this->loginRepo = $loginRepo;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function checkPassword(array $data)
    {
        $user = $this->userRepo->getUserByName($data["name"]);

        if($user === null)
            return [
                'user_id' => null,
                'token' => null,
            ];

        if(!$this->passwordService->password_verify($data['password'], $user->getHash()))
            return [
                'user_id' => $user->getId(),
                'token' => null,
            ];

        $tokenBytes = $this->container->getParameter('token.bytes');
        $token = $this->tokenGenerator->generate($tokenBytes);
        $login = $this->loginFactory->createLogin($user);
        $this->loginRepo->save($login, true);
        $user->setLastLogin($login);
        $user->setToken($token);
        $this->userRepo->save($user, false);

        return [
            "user_id" => $user->getId(),
            "token" => $token,
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function checkToken(array $data)
    {
        $user = $this->userRepo->getUserByID($data['user_id']);

        if($user === null)
            return [
                'user_id' => null
            ];

        if(!$this->tokenGenerator->verify($data['token'], $user->getToken()))
            return [
                'user_id' => $user->getId(),
                'token' => null,
            ];
        $tokenBytes = $this->container->getParameter('token.bytes');
        $token = $this->tokenGenerator->generate($tokenBytes);
        $user->setToken($token);
        $this->userRepo->save($user, false);

        return [
            "user_id" => $user->getId(),
            "token" => $token,
        ];
    }

    /**
     * @param array $data
     * @return bool|null
     */
    public function deleteToken(array $data)
    {
        $user = $this->userRepo->getUserByID($data['user_id']);

        if($user === null)
            return null;

        $token = $user->getToken();
        if($token === null)
            return false;

        $user->setToken(null);
        $this->userRepo->save($user, false);

        return true;
    }
}
