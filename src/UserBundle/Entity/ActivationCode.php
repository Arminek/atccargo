<?php

namespace UserBundle\Entity;

class ActivationCode implements ActivationCodeInterface
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $activationCode;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function generateRegistrationCode()
    {
        return rand(1000, 9999);
    }
}

