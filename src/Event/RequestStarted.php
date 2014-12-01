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

/**
 * HTTP Request Started event
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class RequestStarted extends RequestEvent
{
    const NAME = 'requestStarted';
}
