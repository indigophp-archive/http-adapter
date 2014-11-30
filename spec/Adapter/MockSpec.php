<?php

namespace spec\Indigo\Http\Adapter;

use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;

class MockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Mock');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_accept_response(Response $response)
    {
        $this->beConstructedWith($response);
    }

    function it_should_allow_to_set_response(Response $response)
    {
        $this->setResponse($response);
    }

    public function it_should_return_response(Request $request, Response $response)
    {
        $this->setResponse($response);
        $this->send($request)->shouldReturn($response);
    }

    function it_should_throw_an_exception_when_response_is_invalid(Request $request)
    {
        $this->setResponse(null);
        $this->shouldThrow('Indigo\Http\Exception\AdapterException')
            ->duringSend($request);
    }
}
