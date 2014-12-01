<?php

namespace spec\Indigo\Http\Listener;

use Indigo\Http\Event\RequestStarted;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use PhpSpec\ObjectBehavior;

class AuthSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('user', 'pass');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Listener\Auth');
        $this->shouldHaveType('Indigo\Http\Listener\Base');
        $this->shouldImplement('League\Event\ListenerProviderInterface');
    }

    function it_should_listen_to_request_started_event(RequestStarted $event, Request $request)
    {
        $event->getRequest()->willReturn($request);

        $request->setHeader('Authentication', 'Basic '.base64_encode('user:pass'))->shouldBeCalled();

        $this->requestStarted($event);
    }

    function it_should_throw_an_exception_when_digest_auth_selected(RequestStarted $event, Request $request)
    {
        $this->beConstructedWith('user', 'pass', 2);
        $event->getRequest()->willReturn($request);

        $this->shouldThrow('LogicException')->duringRequestStarted($event);
    }

    function it_should_throw_an_exception_when_auth_type_is_unsupported(RequestStarted $event, Request $request)
    {
        $this->beConstructedWith('user', 'pass', 'fail');
        $event->getRequest()->willReturn($request);

        $this->shouldThrow('RuntimeException')->duringRequestStarted($event);
    }
}
