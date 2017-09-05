<?php
/**
 * Created by PhpStorm.
 * User: abdelhak
 * Date: 04/09/2017
 * Time: 21:19
 */

namespace Model;


class Message
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $contenu;

    /**
     * @var User
     */
    private $user;

    /**
     * Messages constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

   /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }


}