<?php

namespace spec\Indigo\Http\Message;

use PhpSpec\ObjectBehavior;

class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Message\Response');
        $this->shouldHaveType('Psr\Http\Message\ResponseInterface');
    }

    function it_should_allow_to_set_status_code()
    {
        $this->setStatusCode(200);
        $this->getStatusCode()->shouldReturn(200);
    }

    function it_should_set_reason_phrase_when_status_is_set()
    {
        $this->setStatusCode(200);

        $this->getReasonPhrase()->shouldBe('OK');
    }

    function it_should_set_reason_phrase_to_unknown_when_status_is_unknown()
    {
        $this->setStatusCode(599);

        $this->getReasonPhrase()->shouldBe('Unknown');
    }

    function it_should_throw_an_exception_when_the_status_code_is_string()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetStatusCode('000');
    }

    function it_should_throw_an_exception_when_the_status_code_is_out_of_rang()
    {
        $this->shouldThrow('InvalidArgumentException')->duringSetStatusCode(600);
    }

    function it_should_allow_to_set_reason_phrase()
    {
        $this->setReasonPhrase('OK');
        $this->getReasonPhrase()->shouldReturn('OK');
    }
}
