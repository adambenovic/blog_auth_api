<?php

namespace App\Service;

class PasswordService
{
    public function password_generate(string $salt, string $password)
    {
        return password_hash($salt . $password, PASSWORD_BCRYPT);
    }

    public function password_verify(string $hash)
    {
        //TODO Retrieve the user's salt and hash from the database.
        // Prepend the salt to the given password and hash it using the same hash function.
        // Compare the hash of the given password with the hash from the database.
        // If they match, the password is correct. Otherwise, the password is incorrect.
    }

    public function salt_generate()
    {
        return openssl_random_pseudo_bytes(32);
    }
}
