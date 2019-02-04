<?php

namespace App\Service;

class TokenService
{
    /**
     * @param int $bytes
     * @return string
     */
    public function generate(int $bytes)
    {
        return bin2hex(openssl_random_pseudo_bytes($bytes));
    }

    /**
     * @param string $token
     * @param string $dbToken
     * @return bool
     */
    public function verify(string $token, string $dbToken)
    {
        return $token == $dbToken ? true : false;
    }
}
