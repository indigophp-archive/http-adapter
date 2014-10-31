<?php

namespace spec\Indigo\Http\Stub;

use Psr\Http\Message\StreamableInterface;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Stub\Message');
        $this->shouldImplement('Psr\Http\Message\MessageInterface');
        $this->shouldUseTrait('Indigo\Http\Message\Message');
    }

    function it_should_have_protocol_version()
    {
        $this->getProtocolVersion()->shouldReturn('1.1');
    }

    function it_should_allow_to_set_protocol_version()
    {
        $this->setProtocolVersion('1.0');
        $this->getProtocolVersion()->shouldReturn('1.0');
    }

    function it_should_accept_a_body(StreamableInterface $body)
    {
        $this->setBody($body);
        $this->getBody()->shouldReturn($body);
    }

    function it_should_expose_headers_as_array()
    {
        $this->getHeaders()->shouldBeArray();
    }

    function it_should_allow_to_check_header_existence()
    {
        $this->shouldNotHaveHeader('header');
        $this->setHeader('header', 'value');
        $this->shouldHaveHeader('header');
    }

    function it_should_return_the_header_as_string()
    {
        $this->setHeader('header', 'value');
        $this->addHeader('header', 'value2');
        $this->getHeader('header')->shouldReturn('value,value2');
    }

    function it_should_return_the_header_as_array()
    {
        $this->setHeader('header', 'value');
        $this->addHeader('header', 'value2');
        $this->getHeaderAsArray('header')->shouldReturn(['value', 'value2']);
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

    public function getMatchers()
    {
        return [
            'useTrait' => function ($subject, $trait) {
                return class_uses($subject, $trait);
            }
        ];
    }
}
