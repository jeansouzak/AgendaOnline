<?php
/**
 * User: jean.souza
 * Date: 07/04/17
 * Time: 00:13
 */

namespace Domain\Service;


use Domain\Entity\User;

class SecurityUserService
{


    /**
     * Encrypt user password
     * @return User
     */
    public function safeUser($user)
    {
        // A higher "cost" is more secure but consumes more processing power
        $cost = 10;

        // Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
        // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $cost) . $salt;


        // Hash the password with the salt
        $hash = crypt($user->getPassword(), $salt);

        $user->setPassword($hash);
    }

    /**
     * Check user password its ok
     * @param string $rawPassword
     * @param string $recordPassword
     * @return bool
     */
    public function checkSameHash($rawPassword, $recordPassword)
    {
        if ( hash_equals($recordPassword, crypt($rawPassword, $recordPassword)) ) {
            return true;
        }
        return false;
    }

}