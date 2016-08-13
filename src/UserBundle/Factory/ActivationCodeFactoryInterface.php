<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Factory;

use UserBundle\Entity\ActivationCodeInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
interface ActivationCodeFactoryInterface
{
    /**
     * @return ActivationCodeInterface
     */
    public function createNew();
}
