<?php

namespace spec\Indigo\Http\Listener;

use Indigo\Http\Event\RequestStarted;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use PhpSpec\ObjectBehavior;

class ApiKeySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('1234');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Listener\ApiKey');
        $this->shouldHaveType('Indigo\Http\Listener\Base');
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_should_listen_to_request_started_event(RequestStarted $event, Request $request)
    {
        $event->getRequest()->willReturn($request);

        $request->getUrl()->willReturn('http://api.com/1.0/test');
        $request->setUrl('http://api.com/1.0/test?key=1234')->will(function($args) {
            $this->getUrl()->willReturn($args[0]);
        })->shouldBeCalled();

        $this->requestStarted($event);
    }
}
