<?php

namespace App\Service;

class PasswordService
{
    /**
     * @param string $password
     * @return bool|string
     */
    public function password_generate(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return mixed
     */
    public function password_verify(string $password, string $hash)
    {
        return $this->password_verify($password, $hash);
    }
}
