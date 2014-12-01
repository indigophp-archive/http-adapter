<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Stub;

use Indigo\Http\Event\DomainEvent as AbstractEvent;

/**
 * Domain Event Stub
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class DomainEvent extends AbstractEvent
{
    const NAME = 'eventStub';
}
