<?php

/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 05/09/2017
 * Time: 08:39
 */

namespace Controller;

use Manager\MessageManager;

class MessageController extends DefaultController
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' and isset($_POST['contenu'])){
            $message = MessageManager::add($this->getUser(),htmlspecialchars($_POST['contenu']));
            header('Content-Type: application/json');
            if($message){
                echo json_encode(['code' => 1]);
            }else{
                echo json_encode(['code' => 0]);;
            }
        }else
            header("location:index.php");
    }

    public function refresh(){
        if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' and isset($_GET['lastShown'])) {
            $lastShown = $_GET['lastShown'];
            $messages = MessageManager::findBy([],['date'=>'DESC'],null,null,$lastShown);
            $result =[];
            foreach ($messages as $msg){
                $result[] =[
                    'id'=>$msg->getId(),
                    'contenu' => $msg->getContenu(),
                    'date' => $msg->getDate()->format('d/m/Y H:i'),
                    'user' => $msg->getUser()->getUsername()
                ];
            }
            header('Content-Type: application/json');
            echo json_encode([
                'code' => 1,
                'messages' => $result
            ]);
        }
    }

}