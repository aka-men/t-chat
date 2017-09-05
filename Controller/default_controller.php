<?php

/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 05/09/2017
 * Time: 08:39
 */

namespace Controller;

use Manager\UserManager;
use Model\User;

class DefaultController
{
    /**
     * @return User|null
     */
    public function getUser(){
        if(!isset($_SESSION['username']))
            return null;
        else
            return UserManager::find($_SESSION['username']);
    }


}