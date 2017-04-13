<?php

namespace Domain\Service;


use Domain\Entity\Enum\PlanType;
use Domain\Repository\PlanRepositoryInterface;

class PlanService
{
    /**
     * @var PlanRepositoryInterface
     */
    private $planRepository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     *
     * @return \Domain\Entity\Plan
     */
    public function getDefaultPlan()
    {
        return $this->planRepository->findPlanByID(PlanType::FREE);
    }




}