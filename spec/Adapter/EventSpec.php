<?php

namespace spec\Indigo\Http\Adapter;

use Indigo\Http\Adapter;
use Indigo\Http\Event\Before;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
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

    function it_should_expose_events(Adapter $adapter, Request $request, Response $response)
    {
        $adapter->send($request)->willReturn($response);
        $this->send($request);
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
