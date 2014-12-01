<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Event;

use League\Event\AbstractEvent;

/**
 * Returns name from a constant
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class DomainEvent extends AbstractEvent
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return static::NAME;
    }
}
