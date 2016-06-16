<?php

namespace UserBundle\Entity;

class ActivationCode
{
    private $id;
    private $email;
    private $role;
    private $activationCode;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getActivationCode()
    {
        return $this->activationCode;
    }

    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    }
    
    public function generateRegistrationCode()
    {
        return rand(1000, 9999);
    }
}

