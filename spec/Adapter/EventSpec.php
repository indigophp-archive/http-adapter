<?php

namespace spec\Indigo\Http\Adapter;

use Indigo\Http\Adapter;
use Indigo\Http\Event\Before;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use Exception;
use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    function let(Adapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Event');
        $this->shouldUseTrait('Indigo\Http\Adapter\Decorator');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_emit_events(Adapter $adapter, Request $request, Response $response)
    {
        $adapter->send($request)->willReturn($response);
        $this->send($request)->shouldReturn($response);
    }

    function it_should_allow_to_intercept_requests(Adapter $adapter, Request $request, Response $response)
    {
        $e = new Exception;

        $adapter->send($request)->willThrow($e);

        $this->addListener('requestFailed', function($event) use ($response) {
            $event->intercept($response->getWrappedObject());
        });

        $this->send($request)->shouldReturn($response);
    }

    function it_should_throw_an_exception_when_not_intercepted(Adapter $adapter, Request $request)
    {
        $e = new Exception;

        $adapter->send($request)->willThrow($e);

        $this->shouldThrow($e)->duringSend($request);
    }

    public function getMatchers()
    {
        return [
            'useTrait' => function ($subject, $trait) {
                return class_uses($subject, $trait);
            }
        ];
    }
}
