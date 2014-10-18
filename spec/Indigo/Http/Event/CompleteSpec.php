<?php

namespace spec\Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PhpSpec\ObjectBehavior;

class CompleteSpec extends ObjectBehavior
{
    protected $adapter;
    protected $request;
    protected $response;

    public function let(Adapter $adapter, Request $request, Response $response)
    {
        $this->beConstructedWith($adapter, $request, $response);

        $this->adapter = $adapter;
        $this->request = $request;
        $this->response = $response;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Event\Complete');
        $this->shouldHaveType('Indigo\Http\Event\Event');
    }

    function it_should_expose_adapter_and_request()
    {
        $this->getAdapter()->shouldReturn($this->adapter);
        $this->getRequest()->shouldReturn($this->request);
        $this->getResponse()->shouldReturn($this->response);
    }
}
