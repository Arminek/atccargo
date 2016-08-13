<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var ActivationCodeInterface
     */
    private $activationCode;

    /**
     * @var mixed
     */
    private $avatar;

    /**
     * @var array
     */
    private $roles = [];

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getActivationCode()
    {
        return $this->activationCode;
    }

    public function setActivationCode(ActivationCodeInterface $activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
          $this->id,
          $this->username,
          $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
          $this->id,
          $this->username,
          $this->password,
          ) = unserialize($serialized);
    }
}