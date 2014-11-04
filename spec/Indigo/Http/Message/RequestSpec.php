<?php

namespace spec\Indigo\Http\Message;

use Psr\Http\Message\StreamableInterface;
use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Message\Request');
        $this->shouldImplement('use Psr\Http\Message\OutgoingRequestInterface');
    }

    function it_should_allow_to_set_protocol_version()
    {
        $this->setProtocolVersion('1.0');
        $this->getProtocolVersion()->shouldReturn('1.0');
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

    function it_should_allow_to_set_header()
    {
        $this->setHeader('header', 'value');
        $this->getHeader('header')->shouldReturn('value');
        $this->getHeaders()->shouldHaveCount(1);
        $this->setHeader('header', ['value']);
        $this->getHeaderAsArray('header')->shouldHaveCount(1);
    }

    function it_should_allow_to_add_header()
    {
        $this->addHeader('header', 'value');
        $this->getHeaderAsArray('header')->shouldHaveCount(1);
        $this->addHeader('header', 'value2');
        $this->getHeaderAsArray('header')->shouldHaveCount(2);
    }

    function it_should_allow_to_remove_header()
    {
        $this->addHeader('header', 'value');
        $this->getHeaderAsArray('header')->shouldHaveCount(1);
        $this->removeHeader('header');
        $this->getHeaderAsArray('header')->shouldHaveCount(0);
    }

    function it_should_allow_to_set_body(StreamableInterface $body)
    {
        $this->setBody($body);

        $this->getBody()->shouldReturn($body);
    }
}
