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

use Indigo\Http\Listener\Base;
use Indigo\Http\Event\RequestStarted;

/**
 * Listener Stub
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Listener extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $events = ['requestStarted'];

    /**
     * Listens to RequestStarted event
     *
     * @param RequestStarted $event
     */
    public function requestStarted(RequestStarted $event)
    {
        // noop
    }
}
