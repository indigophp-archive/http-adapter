<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\ListenerProvider;

use League\Event\ListenerProviderInterface;
use League\Event\ListenerAcceptorInterface;

/**
 * Simple implementation of ListenerProviders
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class Base implements ListenerProviderInterface
{
    use ListenerProvider;

    /**
     * List of provided events
     *
     * @var array
     */
    protected $events = [];

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return $this->events;
    }
}
