<?php

namespace App\Factory;

use App\Entity\Login;
use App\Entity\User;
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
     * @param User $user
     * @return Login
     */
    public function createLogin(User $user)
    {
        return new Login($user);
    }
}
