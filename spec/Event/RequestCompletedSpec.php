<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;

class RequestCompletedSpec extends ObjectBehavior
{
    public function let(Adapter $adapter, Request $request, Response $response)
    {
        $this->beConstructedWith($adapter, $request, $response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\RequestCompleted');
        $this->shouldHaveType('Indigo\Http\Event\RequestEvent');
    }

    function it_should_have_a_response(Response $response)
    {
        $this->getResponse()->shouldReturn($response);
    }
}
