<?php

namespace Infrastructure;

use Domain\Repository\ContactRepositoryInterface;
use Domain\Repository\PlanRepositoryInterface;
use Domain\Repository\UserRepositoryInterface;
use Infrastructure\Enviroment\Enviroment;
use League\Container\Container;

class Infrastructure
{
    /**
     * @var Container
     */
    private static $container;

    private function __construct()
    {
    }

    /**
     * @return Container
     */
    static public function getContainer()
    {
        if (self::$container === null) {
            self::$container = new Container;
            self::setupSettings();
        }

        return self::$container;
    }

    static public function loadEnviromentSettings()
    {
        $dotenv = new \Dotenv\Dotenv(ROOT_DIR);
        $dotenv->load();

        if (getenv('APP_ENV') == Enviroment::DEV) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
    }

    private static function setupSettings()
    {
        self::$container->add(UserRepositoryInterface::class, 'Infrastructure\Pdo\Repository\UserRepository');
        self::$container->add(ContactRepositoryInterface::class, 'Infrastructure\Pdo\Repository\ContactRepository');
        self::$container->add(PlanRepositoryInterface::class, 'Infrastructure\Pdo\Repository\PlanRepository');

    }

}