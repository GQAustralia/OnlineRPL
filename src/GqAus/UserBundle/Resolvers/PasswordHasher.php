<?php

namespace GqAus\UserBundle\Resolvers;

trait PasswordHasher
{
    /**
     * @param $password
     *
     * @return bool|false|string
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}