<?php

namespace spec\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\ActivationCodeInterface;
use UserBundle\Entity\User;
use PhpSpec\ObjectBehavior;

/**
 * @mixin User
 */
class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_implements_user_interface()
    {
        $this->shouldImplement(UserInterface::class);
    }

    function it_has_username()
    {
        $this->setUsername('John doe');

        $this->getUsername()->shouldReturn('John doe');
    }

    function it_has_password_and_plain_password()
    {
        $this->setPassword('john123');
        $this->setPlainPassword('john123');

        $this->getPassword()->shouldReturn('john123');
        $this->getPlainPassword()->shouldReturn('john123');
    }

    function it_has_email()
    {
        $this->setEmail('john@example.com');

        $this->getEmail()->shouldReturn('john@example.com');
    }

    function it_has_activation_code(ActivationCodeInterface $activationCode)
    {
        $this->setActivationCode($activationCode);

        $this->getActivationCode()->shouldReturn($activationCode);
    }
}
