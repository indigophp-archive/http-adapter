<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use Exception;
use PhpSpec\ObjectBehavior;

class RequestErroredSpec extends ObjectBehavior
{
    public function let(Adapter $adapter, Request $request, Exception $e)
    {
        $this->beConstructedWith($adapter, $request, $e);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\RequestFailed');
        $this->shouldHaveType('Indigo\Http\Event\RequestEvent');
    }

    public function it_should_have_an_exception(Exception $e)
    {
        $this->getException()->shouldReturn($e);
    }

    public function it_should_allow_to_intercept_a_request(Response $response)
    {
        $this->getResponse()->shouldReturn(null);

        $this->intercept($response);

        $this->isIntercepted()->shouldReturn(true);
        $this->getResponse()->shouldReturn($response);
    }
}
