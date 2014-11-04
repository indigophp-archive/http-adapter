<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use PhpSpec\ObjectBehavior;

class BeforeSpec extends ObjectBehavior
{
    protected $adapter;
    protected $request;

    public function let(Adapter $adapter, Request $request)
    {
        $this->beConstructedWith($adapter, $request);

        $this->adapter = $adapter;
        $this->request = $request;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\Before');
        $this->shouldHaveType('Indigo\Http\Event\Event');
    }

    function it_should_expose_adapter_and_request()
    {
        $this->getAdapter()->shouldReturn($this->adapter);
        $this->getRequest()->shouldReturn($this->request);
    }
}
