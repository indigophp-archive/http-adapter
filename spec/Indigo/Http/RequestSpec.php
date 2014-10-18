<?php

namespace spec\Indigo\Http;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Request');
        $this->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_should_allow_to_set_method()
    {
        $this->setMethod('GET');
        $this->getMethod()->shouldReturn('GET');
    }

    function it_should_allow_to_set_url()
    {
        $this->setUrl('http://foo.com');
        $this->getUrl()->shouldReturn('http://foo.com');
    }
}
