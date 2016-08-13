<?php

namespace spec\UserBundle\Entity;

use UserBundle\Entity\ActivationCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UserBundle\Entity\ActivationCodeInterface;

/**
 * @mixin ActivationCode
 */
class ActivationCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ActivationCode::class);
    }

    function it_implements_activation_code_interface()
    {
        $this->shouldImplement(ActivationCodeInterface::class);
    }

    function it_has_email()
    {
        $this->setActivationCode('john@example.com');

        $this->getActivationCode()->shouldReturn('john@example.com');
    }

    function it_has_role()
    {
        $this->setRole('EXAMPLE_ROLE');

        $this->getRole()->shouldReturn('EXAMPLE_ROLE');
    }

    function it_has_activation_code()
    {
        $this->setActivationCode('xyz');

        $this->getActivationCode()->shouldReturn('xyz');
    }
}
