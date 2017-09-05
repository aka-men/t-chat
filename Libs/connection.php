<?php
/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 04/09/2017
 * Time: 20:50
 */

namespace Libs;


class Connection
{

    const DB_NAME = 't_chat';
    const DB_USER_NAME = 'root';
    const DB_USER_PASS = '';

    private static $_instance;

    /**
     * @return \PDO
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            try {
                self::$_instance = new \PDO('mysql:host=localhost;dbname='.self::DB_NAME, self::DB_USER_NAME, self::DB_USER_PASS);
            } catch (\PDOException $e) {
                throw $e;
            }
        }
        return self::$_instance;
    }

}