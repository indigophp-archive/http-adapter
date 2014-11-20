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
 * Array implementation of ListenerProviders
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class ListenerProvider implements ListenerProviderInterface
{
    /**
     * List of events
     *
     * @var array
     */
    protected $events = [];

    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $events = $this->getEvents();

        foreach ($events as $event) {
            $listenerAcceptor->addListener($event, [$this, $event]);
        }
    }

    /**
     * Returns the provided events
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }
}
