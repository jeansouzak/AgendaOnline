<?php

namespace Domain\Repository;



use Domain\Entity\Plan;

interface PlanRepositoryInterface
{

    /**
     * @param $id
     * @return Plan
     */
    public function findPlanByID($id);

}