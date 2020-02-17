<?php

namespace App;

/**
 * Class DB
 */
class DB
{
    protected static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function get_instance () {
        /**
         * @var $mysql
         */
        include __DIR__ . '/../config.php';
        /**
         * @var $host
         * @var $user
         * @var $password
         * @var $database
         */
        foreach ($mysql as $key => $val)
            $$key = $val;

        if (self::$instance === null) {
            self::$instance = new \mysqli($host, $user, $password, $database);
        }
        return self::$instance;
    }

}

/**
 * Trait database
 */
trait Database
{
    public function db () {
        return DB::get_instance();
    }
}

