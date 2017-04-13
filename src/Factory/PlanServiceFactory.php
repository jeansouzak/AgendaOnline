<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 23:04
 */

namespace Domain\Factory;



use Domain\Repository\PlanRepositoryInterface;
use Domain\Service\PlanService;
use Infrastructure\Infrastructure;

class PlanServiceFactory
{

    /**
     * @return PlanService
     */
    public static function getInstance()
    {
        return new PlanService(Infrastructure::getContainer()->get(PlanRepositoryInterface::class));

    }

}