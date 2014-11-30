<?php

namespace spec\Indigo\Http\Adapter;

use Psr\Http\Message\OutgoingRequestInterface as Request;
use Buzz\Browser;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use Buzz\Message\Factory\Factory;
use PhpSpec\ObjectBehavior;

class BuzzSpec extends ObjectBehavior
{
    function let(Browser $browser)
    {
        $this->beConstructedWith($browser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Buzz');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_return_a_response(Browser $browser, Request $request, BuzzRequest $buzzRequest, BuzzResponse $buzzResponse, Factory $factory)
    {
        $request->getMethod()->willReturn('GET');
        $request->getUrl()->willReturn('http://foo.com');
        $request->getProtocolVersion()->willReturn('1.1');
        $request->getHeaders()->willReturn([]);
        $request->getBody()->willReturn(null);

        $buzzResponse->getStatusCode()->willReturn(200);
        $buzzResponse->getProtocolVersion()->willReturn('1.1');
        $buzzResponse->getHeaders()->willReturn([]);
        $buzzResponse->getContent()->willReturn(null);

        $browser->getMessageFactory()->willReturn($factory);
        $factory->createRequest('GET', 'http://foo.com')->willReturn($buzzRequest);
        $browser->send($buzzRequest)->willReturn($buzzResponse);

        $response = $this->send($request);

        $response->getStatusCode()->shouldReturn(200);
        $response->getProtocolVersion()->shouldReturn('1.1');
    }
}
