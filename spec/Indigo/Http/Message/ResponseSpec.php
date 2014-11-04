<?php

namespace spec\Indigo\Http\Message;

use Psr\Http\Message\StreamableInterface;
use PhpSpec\ObjectBehavior;

class ResponseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(200);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Message\Response');
        $this->shouldImplement('Psr\Http\Message\IncomingResponseInterface');
    }

    function it_should_have_status_code()
    {
        $this->beConstructedWith(200);

        $this->getStatusCode()->shouldReturn(200);
    }

    function it_should_set_reason_phrase_from_status()
    {
        $this->beConstructedWith(200);

        $this->getReasonPhrase()->shouldBe('OK');
    }

    function it_should_set_reason_phrase_to_unknown_when_status_is_unknown()
    {
        $this->beConstructedWith(599);

        $this->getReasonPhrase()->shouldBe('Unknown');
    }

    function it_should_throw_an_exception_when_the_status_code_is_string()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['000']);
    }

    function it_should_throw_an_exception_when_the_status_code_is_out_of_range()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', [600]);
    }

    function it_should_allow_to_set_reason_phrase()
    {
        $this->beConstructedWith(200, 'Something Else');

        $this->getReasonPhrase()->shouldBe('Something Else');
    }

    function it_should_allow_to_set_body(StreamableInterface $body)
    {
        $this->beConstructedWith(200, null, [], $body);

        $this->getBody()->shouldReturn($body);
    }

    function it_should_allow_to_set_headers()
    {
        $this->beConstructedWith(200, null, [
            'header'       => 'value',
            'other_header' => [
                'value1',
                'value2',
            ],
        ]);

        $this->getHeader('header')->shouldReturn('value');
        $this->getHeader('other_header')->shouldReturn('value1,value2');
    }
}
