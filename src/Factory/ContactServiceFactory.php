<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 23:04
 */

namespace Domain\Factory;


use Domain\Repository\ContactRepositoryInterface;
use Domain\Service\ContactService;
use Infrastructure\Infrastructure;

class ContactServiceFactory
{

    /**
     * @return ContactService
     */
    public static function getInstance()
    {
        return new ContactService(Infrastructure::getContainer()->get(ContactRepositoryInterface::class));

    }

}