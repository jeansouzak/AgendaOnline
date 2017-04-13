<?php

namespace Domain\Entity;


class Contact
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $number;


    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $bornDay;

    /**
     * @var int
     */
    private $bornMonth;

    /**
     * @var array
     */
    private $notifications;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
    public function getBornDay()
    {
        return $this->bornDay;
    }

    /**
     * @param int $bornDay
     */
    public function setBornDay($bornDay)
    {
        $this->bornDay = $bornDay;
    }

    /**
     * @return int
     */
    public function getBornMonth()
    {
        return $this->bornMonth;
    }

    /**
     * @param int $bornMonth
     */
    public function setBornMonth($bornMonth)
    {
        $this->bornMonth = $bornMonth;
    }

    /**
     * @return array
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param array $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }


    public function addNotification($notification)
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }


}