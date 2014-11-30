<?php

namespace spec\Indigo\Http\Stub;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use PhpSpec\ObjectBehavior;

class DecoratorSpec extends ObjectBehavior
{
    function let(Adapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Stub\Decorator');
        $this->shouldImplement('Indigo\Http\Adapter');
        $this->shouldUseTrait('Indigo\Http\Adapter\Decorator');
    }

    function it_should_expose_an_adapter()
    {
        $this->getAdapter()->shouldHaveType('Indigo\Http\Adapter');
    }

    function it_should_allow_to_send_a_request(Request $request)
    {
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
