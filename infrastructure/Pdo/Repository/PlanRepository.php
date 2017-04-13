<?php

namespace Infrastructure\Pdo\Repository;


use Domain\Entity\Plan;
use Domain\Entity\User;
use Domain\Repository\PlanRepositoryInterface;
use Infrastructure\Pdo\Connection\Db;

class PlanRepository implements PlanRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function findPlanByID($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM plan WHERE id = :id');
        $stmt->execute([
            'id' => $id
        ]);

        $plan = $stmt->fetchObject(Plan::class);

        return $plan;
    }


}