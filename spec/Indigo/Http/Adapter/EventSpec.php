<?php

namespace spec\Indigo\Http\Adapter;

use Indigo\Http\Adapter;
use Indigo\Http\Event\Before;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use League\Event\ListenerInterface as Listener;
use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    protected $adapter;

    function let(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Event');
        $this->shouldUseTrait('Indigo\Http\Adapter\Decorator');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_expose_events(Request $request, Response $response)
    {
        $this->adapter->send($request)->willReturn($response);
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
