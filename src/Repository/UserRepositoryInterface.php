<?php

namespace Domain\Repository;


use Domain\Entity\User;

interface UserRepositoryInterface
{

    /**
     * @param User $user
     * @return bool
     * Save user on database
     */
    public function save(User $user);


    /**
     * @param string $email
     * @return User
     * find an user by email
     */
    public function findUserByEmail($email);

}