<?php

namespace App\Factory;

use App\Entity\Login;
use App\Entity\Api_User;
use App\Repository\LoginRepository;

class LoginFactory
{
    /**
     * @var LoginRepository
     */
    private $loginRepo;

    /**
     * LoginFactory constructor.
     * @param LoginRepository $loginRepo
     */
    public function __construct(
        LoginRepository $loginRepo
    ){
        $this->loginRepo = $loginRepo;
    }

    /**
     * @param Api_User $user
     * @return Login
     * @throws \Exception
     */
    public function createLogin(Api_User $user)
    {
        return new Login($user);
    }
}
