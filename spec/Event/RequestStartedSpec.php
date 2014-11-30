<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use PhpSpec\ObjectBehavior;

class RequestStartedSpec extends ObjectBehavior
{
    public function let(Adapter $adapter, Request $request)
    {
        $this->beConstructedWith($adapter, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\RequestStarted');
        $this->shouldHaveType('Indigo\Http\Event\DomainEvent');
    }

    function it_should_expose_adapter_and_request(Adapter $adapter, Request $request)
    {
        $this->getAdapter()->shouldReturn($adapter);
        $this->getRequest()->shouldReturn($request);
    }
}
