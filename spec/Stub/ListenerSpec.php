<?php

namespace spec\Indigo\Http\Stub;

use Indigo\Http\Event\RequestStarted;
use League\Event\Emitter;
use PhpSpec\ObjectBehavior;

class ListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Stub\Listener');
        $this->shouldHaveType('Indigo\Http\Listener\Base');
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_should_listen_to_request_started_event(RequestStarted $event)
    {
        $emitter = new Emitter;

        $emitter->useListenerProvider($this->getWrappedObject());

        $emitter->emit($event->getWrappedObject());
    }
}
