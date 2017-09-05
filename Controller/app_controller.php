<?php

/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 05/09/2017
 * Time: 08:39
 */

namespace Controller;

use Manager\MessageManager;
use Manager\UserManager;

class AppController extends DefaultController
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }

    public function home(){
        $user = $this->getUser();
        $usersConnected = UserManager::findConnected($user);
        $messages = MessageManager::findBy([],['DATE'=>'DESC'],50,0);
        require_once 'View/layout.php';
    }

    public function error404(){
        require_once 'View/404.html';
    }

}