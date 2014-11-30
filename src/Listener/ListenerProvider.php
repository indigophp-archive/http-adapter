<?php

/*
 * This file is part of the Diagnose package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Listener;

use League\Event\ListenerAcceptorInterface;

/**
 * ListenerProvider logic
 *
 * Classes using this trait should implement League\Event\ListenerProviderInterface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait ListenerProvider
{
    /**
     * {@inheritdoc}
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $events = $this->getEvents();

        foreach ($events as $event => $listener) {
            // Listener name can be the same as the event name
            if (is_null($listener)) {
                $listener = $event;
            }

            $listenerAcceptor->addListener($event, [$this, $listener]);
        }
    }

    /**
     * Returns the list of events
     *
     * @return array
     */
    abstract public function getEvents();
}
