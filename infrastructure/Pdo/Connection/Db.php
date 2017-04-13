<?php

namespace Infrastructure\Pdo\Connection;


class Db
{
    private static $instance = null;

    private function __construct()
    {

    }

    /**
     * @return \PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new \PDO(sprintf('%s:host=%s;dbname=%s', getenv('DB_DRIVER'),
                getenv('DB_HOST'), getenv('DB_DATABASE')),
                getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        }
        return self::$instance;
    }


}