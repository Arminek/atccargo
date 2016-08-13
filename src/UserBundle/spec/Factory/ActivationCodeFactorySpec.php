<?php

namespace spec\UserBundle\Factory;

use UserBundle\Entity\ActivationCodeInterface;
use UserBundle\Factory\ActivationCodeFactory;
use PhpSpec\ObjectBehavior;
use UserBundle\Factory\ActivationCodeFactoryInterface;

/**
 * @mixin ActivationCodeFactory
 */
class ActivationCodeFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ActivationCodeFactory::class);
    }

    function it_implements_code_factory_interface()
    {
        $this->shouldImplement(ActivationCodeFactoryInterface::class);
    }

    function it_creates_new_activation_code()
    {
        $this->createNew()->shouldHaveType(ActivationCodeInterface::class);
    }
}
