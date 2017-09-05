<?php
/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 04/09/2017
 * Time: 21:50
 */

namespace Manager;

use Libs\Connection;
use Model\User;

class UserManager
{
    /**
     * @param $username
     * @return User|null
     */
    public static function find($username){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindValue(':username', $username);
        $query->execute();
        if($query->rowCount() > 0){
            $data = (array)$query->fetchObject();
            $user = self::create();
            $user->setUsername($data['USERNAME']);
            $user->setPassword($data['PASSWORD']);
            $user->setId($data['ID']);
            return $user;
        }else
            return null;
    }

    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public static function login($username,$password){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $query->bindValue(':username', $username);
        $query->bindValue(':password', $password);
        $query->execute();
        if($query->rowCount() > 0){
            $data = (array)$query->fetchObject();
            $user = self::create();
            $user->setUsername($data['USERNAME']);
            $user->setPassword($data['PASSWORD']);
            $user->setId($data['ID']);
            return $user;
        }else{
            if(self::find($username))
                return null;
            else{
                return self::add($username,$password);
            }
        }
    }

    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public static function add($username,$password){
        if(self::find($username))
            return null;
        try{
            $pdo = Connection::getInstance();
            $query = $pdo->prepare("INSERT INTO `users` (`USERNAME`, `PASSWORD`) VALUES (:username, :password)");
            $query->bindValue(':username', $username);
            $query->bindValue(':password', $password);
            $pdo->beginTransaction();
            $query->execute();
            $id = $pdo->lastInsertId();
            $result = $pdo->commit();
            if($id and $result){
                $user = self::create();
                $user->setId($id);
                $user->setUsername($username);
                $user->setPassword($password);
                return $user;
            }
            return null;
        }catch (\PDOException $e){
            $pdo->rollBack();
        }
    }

    /**
     * @param $username
     */
    public static function makeOnLine(User $user){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("UPDATE users SET ONLINE = '1' WHERE ID = ?");
        $query->execute([$user->getId()]);
    }

    /**
     * @param $username
     */
    public static function makeOffLine(User $user){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("UPDATE users SET ONLINE = '0' WHERE ID = ?");
        $query->execute([$user->getId()]);
    }

    /**
     * @param User $curentUser
     * @return array
     */
    public static function findConnected(User $curentUser){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE ONLINE = '1' AND ID <> ?");
        $query->execute([$curentUser->getId()]);
        $users = [];
        foreach($query->fetchAll() as $line) {
            $user = self::create();
            $user->setUsername($line['USERNAME']);
            $user->setId($line['ID']);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @return User
     */
    public static function create(){
        return new User();
    }

}