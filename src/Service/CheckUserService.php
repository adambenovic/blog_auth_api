<?php

namespace App\Service;

use App\Repository\UserRepository;

class CheckUserService
{
    private $userRepo;
    private $tokenGenerator;

    public function __construct(
        UserRepository $userRepo,
        TokenGeneratorService $tokenGenerator
    ){
        $this->userRepo = $userRepo;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function check(array $data)
    {
        $user = $this->userRepo->getUserByID($data['name']);

        if($user === null)
            return ["user_id" => null];
        //TODO Implement password decoder
        if($user->getPassword() != $data['password'])
            return null;

        $token = $this->tokenGenerator->generate();
        //TODO Save token to DB

        return [
            "user_id" => $user->getPassword(),
            "token" => $token,
        ];
    }
}
