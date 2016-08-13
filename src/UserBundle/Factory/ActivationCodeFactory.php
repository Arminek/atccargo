<?php

namespace UserBundle\Factory;

use UserBundle\Entity\ActivationCode;

class ActivationCodeFactory implements ActivationCodeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new ActivationCode();
    }
}
