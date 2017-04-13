<?php
/**
 * Created by PhpStorm.
 * User: jean.souza
 * Date: 07/04/17
 * Time: 01:22
 */

namespace Domain\Service;


use Domain\Entity\User;

class AuthenticateService
{

    /**
     * Register an User on session
     * @param User $user
     */
    public function authenticate(User $user)
    {
        $this->startSession();
        if(!array_key_exists('user', $_SESSION)) {
            $_SESSION['user'] = $user;
        }
    }

    /**
     * Destroy session
     */
    public function destroy()
    {
        $this->startSession();
        $_SESSION = [];
        $this->closeSession();

    }

    /**
     * Get User from Session
     * @return User
     */
    public function getUserSession()
    {
        $this->startSession();
        if(array_key_exists('user', $_SESSION)) {
           return $_SESSION['user'];
        }
        return null;
    }

    /**
     * Starts session if is not started
     */
    private function startSession()
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Close session if is started
     */
    private function closeSession()
    {
        if(session_status() != PHP_SESSION_NONE) {
            session_destroy();
        }
    }

}