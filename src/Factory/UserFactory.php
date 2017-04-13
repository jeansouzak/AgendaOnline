<?php

namespace Domain\Factory;


use Domain\Entity\User;

class UserFactory
{
    /**
     * Create an User Object from array parameters
     * @param array $params
     * @return User
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $params)
    {

        if (empty($params['password']) ||
            empty($params['name']) ||
            empty($params['email'])) {
            throw new \InvalidArgumentException('Campo nome, senha e e-mail são obrigatórios.');
        }
        $user = new User();
        $user->setId(array_key_exists('id', $params) ? $params['id'] : null);
        $user->setEmail($params['email']);
        $user->setName($params['name']);
        $user->setPassword($params['password']);

        return $user;
    }

}