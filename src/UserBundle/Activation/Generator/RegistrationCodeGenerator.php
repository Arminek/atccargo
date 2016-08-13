<?php

namespace UserBundle\Activation\Generator;

use UserBundle\Factory\ActivationCodeFactoryInterface;

class RegistrationCodeGenerator implements ActivationCodeGeneratorInterface
{
    /**
     * @var ActivationCodeFactoryInterface
     */
    private $activationCodeFactory;

    /**
     * @param ActivationCodeFactoryInterface $activationCodeFactory
     */
    public function __construct(ActivationCodeFactoryInterface $activationCodeFactory)
    {
        $this->activationCodeFactory = $activationCodeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $registrationCode = $this->activationCodeFactory->createNew();
        $registrationCode->setActivationCode(rand(1000, 9999));

        return $registrationCode;
    }
}
