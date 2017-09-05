<?php
/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 04/09/2017
 * Time: 21:26
 */

namespace Manager;

use Libs\Connection;
use Model\Message;
use Model\User;


class MessageManager
{
    /**
     * @param array $criteria
     * @param array $order
     * @param null $limit
     * @param null $offset
     * @param null $lastShown
     * @return array
     */
    public static function findBy(array $criteria,array $order,$limit = null,$offset = null,$lastShown = null){
        $pdo = Connection::getInstance();
        $sql = "SELECT m.*,u.username AS USER FROM message AS m,users AS u WHERE m.id_user = u.id";
        if($lastShown)
            $sql.= " AND m.id > $lastShown";
        if(!empty($criteria)){
            foreach ($criteria as $key => $value){
                $sql.= " AND $key = :$key";
            }
        }
        if(!empty($order)){
            $first = true;
            foreach ($order as $key => $value){
                $sql.= $first ? ' ORDER BY' : ',';
                $sql.= " $key $value";
                $first = false;
            }
        }
        if(!is_null($limit) and !is_null($offset))
            $sql.= " LIMIT $limit OFFSET $offset";
        $query = $pdo->prepare($sql);
        foreach ($criteria as $key => $value){
           $query->bindValue(":$key",$value);
        }
        $query->execute();
        $messages = [];
        foreach($query->fetchAll() as $line) {
            $message = self::create();
            $message->setDate(new \DateTime($line['DATE']));
            $message->setContenu($line['CONTENU']);
            $message->setId($line['ID']);
            $user = UserManager::create();
            $user->setId($line['ID_USER']);
            $user->setUsername($line['USER']);
            $message->setUser($user);
            $messages[] = $message;
        }
        return array_reverse($messages);
    }

    /**
     * @param User $user
     * @param $contenu
     * @return User|null
     */
    public static function add(User $user,$contenu){
        try{
            $pdo = Connection::getInstance();
            $query = $pdo->prepare("INSERT INTO `message` (`ID_USER`, `CONTENU`) VALUES (:userid, :contenu)");
            $query->bindValue(':userid', $user->getId());
            $query->bindValue(':contenu', $contenu);
            $pdo->beginTransaction();
            $query->execute();
            $id = $pdo->lastInsertId();
            $result = $pdo->commit();
            if($id and $result){
                $message = self::create();
                $message->setId($id);
                $message->setContenu($contenu);
                $message->setUser($user);
                return $message;
            }
            return null;
        }catch (\PDOException $e){
            $pdo->rollBack();
        }
    }

    /**
     * @return Message
     */
    public static function create(){
        return new Message();
    }

}