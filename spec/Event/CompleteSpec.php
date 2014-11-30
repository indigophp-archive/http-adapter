<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;

class CompleteSpec extends ObjectBehavior
{
    public function let(Adapter $adapter, Request $request, Response $response)
    {
        $this->beConstructedWith($adapter, $request, $response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\Complete');
        $this->shouldHaveType('Indigo\Http\Event\Event');
    }

    function it_should_expose_adapter_and_request(Adapter $adapter, Request $request, Response $response)
    {
        $this->getAdapter()->shouldReturn($adapter);
        $this->getRequest()->shouldReturn($request);
        $this->getResponse()->shouldReturn($response);
    }
}
