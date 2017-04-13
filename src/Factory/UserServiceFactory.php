<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 23:04
 */

namespace Domain\Factory;


use Domain\Repository\UserRepositoryInterface;
use Domain\Service\UserService;
use Infrastructure\Infrastructure;

class UserServiceFactory
{

    /**
     * @return UserService
     */
    public static function getInstance()
    {
        return new UserService(Infrastructure::getContainer()->get(UserRepositoryInterface::class));

    }

}