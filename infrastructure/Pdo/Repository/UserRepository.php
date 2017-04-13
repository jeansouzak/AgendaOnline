<?php

namespace Infrastructure\Pdo\Repository;


use Domain\Entity\Plan;
use Domain\Entity\User;
use Domain\Factory\PlanFactory;
use Domain\Factory\UserFactory;
use Domain\Repository\UserRepositoryInterface;
use Infrastructure\Pdo\Connection\Db;

class UserRepository implements UserRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function save(User $user)
    {
        $stmt = $this->db->prepare('INSERT INTO user(name, email, password, plan_id) VALUES (:name, :email,
                                    :password, :plan)');

        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $planID = $user->getPlan()->getId();

        $stmt->bindParam('name', $name, \PDO::PARAM_STR);
        $stmt->bindParam('email', $email, \PDO::PARAM_STR);
        $stmt->bindParam('password', $password, \PDO::PARAM_STR);
        $stmt->bindParam('plan', $planID, \PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function findUserByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT user.*,
                                    plan.name as planName, plan.limit, plan.id as planID
                                    FROM user INNER JOIN plan ON plan.id = user.plan_id WHERE email = :email');
        $stmt->execute([
            'email' => $email
        ]);
        $user = null;
        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($userData) {
            $user = UserFactory::createFromArray($userData);
            $plan = new Plan();
            $plan->setId($userData['planID']);
            $plan->setName($userData['planName']);
            $plan->setLimit($userData['limit']);
            $user->setPlan($plan);
        }
        return $user;
    }


}