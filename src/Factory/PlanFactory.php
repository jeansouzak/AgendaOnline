<?php

namespace Domain\Factory;


use Domain\Entity\Plan;

class PlanFactory
{
    /**
     * Create a Plan object
     * @param array $params
     * @return Plan
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $params)
    {

        if (empty($params['name']) ||
            empty($params['limit'])
            ) {
            throw new \InvalidArgumentException('Campo nome e limite são obrigatórios.');
        }
        $plan = new Plan();
        $plan->setId(array_key_exists('id', $params) ? $params['id'] : null);
        $plan->setName($params['name']);
        $plan->setLimit($params['limit']);

        return $plan;
    }

}