<?php

namespace spec\Indigo\Http;

use PhpSpec\ObjectBehavior;

class StreamSpec extends ObjectBehavior
{
    function let()
    {
        $stream = fopen('php://temp', 'r+');

        fwrite($stream, 'Test content');
        fseek($stream, 0);

        $this->attach($stream);
    }

    function letgo()
    {
        $this->close();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Stream');
        $this->shouldHaveType('Psr\Http\Message\StreamableInterface');
    }

    function it_should_allow_casting_to_string()
    {
        $this->__toString()->shouldBeEqualTo('Test content');
    }

    function it_should_return_stream_and_reset_state_on_detach()
    {
        $this->detach()->shouldBeResource();

        $this->isSeekable()->shouldReturn(false);
        $this->isWritable()->shouldReturn(false);
        $this->isReadable()->shouldReturn(false);
    }

    function it_should_have_state()
    {
        $this->isSeekable()->shouldReturn(true);
        $this->isWritable()->shouldReturn(true);
        $this->isReadable()->shouldReturn(true);
    }

    function it_should_have_meta()
    {
        $this->getMetadata()->shouldBeArray();
        $this->getMetadata('mode')->shouldBeString();
    }

    function it_should_throw_an_exception_when_the_stream_is_not_resource()
    {
        $this->shouldThrow('InvalidArgumentException')->duringAttach('not_a_resource');
    }

    function it_should_not_have_a_size()
    {
        $this->getSize()->shouldBeNull();
    }

    function it_should_allow_to_seek_to_a_position()
    {
        $this->seek(5);
        $this->tell()->shouldBe(5);
        $this->eof()->shouldBe(false);
    }

    function it_should_allow_write()
    {
        $this->write('Another content')->shouldReturn(15);

        $this->__toString()->shouldReturn('Another content');
        $this->eof()->shouldReturn(true);
    }

    function it_should_allow_read()
    {
        $this->read(1)->shouldReturn('T');
        $this->getContents()->shouldReturn('est content');
    }
}
