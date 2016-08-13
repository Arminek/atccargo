<?php

namespace spec\UserBundle\Activation\Generator;

use Prophecy\Argument;
use UserBundle\Activation\Generator\ActivationCodeGeneratorInterface;
use UserBundle\Activation\Generator\RegistrationCodeGenerator;
use PhpSpec\ObjectBehavior;
use UserBundle\Entity\ActivationCodeInterface;
use UserBundle\Factory\ActivationCodeFactoryInterface;

/**
 * @mixin RegistrationCodeGenerator
 */
class RegistrationCodeGeneratorSpec extends ObjectBehavior
{
    function let(ActivationCodeFactoryInterface $activationCodeFactory)
    {
        $this->beConstructedWith($activationCodeFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegistrationCodeGenerator::class);
    }

    function it_implements_generator_interface()
    {
        $this->shouldImplement(ActivationCodeGeneratorInterface::class);
    }

    function it_generates_activation_code(
        ActivationCodeFactoryInterface $activationCodeFactory,
        ActivationCodeInterface $activationCode
    ) {
        $activationCodeFactory->createNew()->willReturn($activationCode);
        $activationCode->setActivationCode(Argument::any())->shouldBeCalled();

        $this->generate();
    }
}
