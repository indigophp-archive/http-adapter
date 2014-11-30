<?php

namespace spec\Indigo\Http\Stub;

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

    function it_should_have_a_body()
    {
        $this->getBody()->shouldReturn(null);
    }

    function it_should_expose_headers_as_array()
    {
        $this->getHeaders()->shouldBeArray();
    }

    function it_should_allow_to_check_header_existence()
    {
        $this->shouldNotHaveHeader('header');
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
