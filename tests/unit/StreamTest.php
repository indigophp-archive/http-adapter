<?php

/*
 * This file is part of the Indigo Some package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http;

use Codeception\TestCase\Test;

/**
 * Tests for Stream
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Stream
 */
class StreamTest extends Test
{
    /**
     * @var Stream
     */
    protected $stream;

    public function _before()
    {
        $stream = fopen('php://temp', 'r+');

        fwrite($stream, 'Test content');
        fseek($stream, 0);

        $this->stream = new Stream;
        $this->stream->attach($stream);
    }

    public function _after()
    {
        $this->stream->close();
    }

    /**
     * @covers ::detach
     * @covers ::attach
     * @covers ::close
     */
    public function testStream()
    {
        $stream = new Stream;

        $detached = $this->stream->detach();
        $meta = stream_get_meta_data($detached);

        $this->assertInternalType('resource', $detached);
        $this->assertFalse($this->stream->isSeekable());
        $this->assertFalse($this->stream->isWritable());
        $this->assertFalse($this->stream->isReadable());

        $this->assertNull($stream->attach($detached));
        $this->assertTrue($stream->isSeekable());
        $this->assertTrue($stream->isWritable());
        $this->assertTrue($stream->isReadable());
        $this->assertEquals($meta, $stream->getMetadata());
        $this->assertNull($stream->close());
        $this->assertFalse($stream->isSeekable());
        $this->assertFalse($stream->isWritable());
        $this->assertFalse($stream->isReadable());
    }

    /**
     * @covers            ::attach
     * @expectedException InvalidArgumentException
     */
    public function testInvalidStream()
    {
        $stream = new Stream;

        $stream->attach('not_a_resource');
    }

    /**
     * @covers ::isSeekable
     * @covers ::isWritable
     * @covers ::isReadable
     */
    public function testState()
    {
        $stream = new Stream;

        // Default state
        $this->assertFalse($stream->isSeekable());
        $this->assertFalse($stream->isWritable());
        $this->assertFalse($stream->isReadable());

        $this->assertTrue($this->stream->isSeekable());
        $this->assertTrue($this->stream->isWritable());
        $this->assertTrue($this->stream->isReadable());
    }

    /**
     * @covers ::__toString
     * @covers ::getContents
     * @covers ::read
     */
    public function testContent()
    {
        $this->assertEquals('T', $this->stream->read(1));
        $this->assertEquals('est content', $this->stream->getContents());
        $this->assertEquals('Test content', (string) $this->stream);
    }

    /**
     * @covers ::getSize
     */
    public function testSize()
    {
        $this->assertNull($this->stream->getSize());
    }

    /**
     * @covers ::tell
     * @covers ::eof
     * @covers ::seek
     */
    public function testPosition()
    {
        $this->assertEquals(0, $this->stream->tell());
        $this->assertTrue($this->stream->seek(1));
        $this->assertEquals(1, $this->stream->tell());
        $this->stream->getContents();
        $this->assertTrue($this->stream->eof());
    }

    /**
     * @covers ::write
     * @covers ::read
     * @covers ::eof
     */
    public function testWriteRead()
    {
        $this->stream->seek(0);

        $this->assertEquals(15, $this->stream->write('Another content'));

        $this->stream->seek(0);

        $this->assertEquals('Another content', $this->stream->read(15));
        $this->assertTrue($this->stream->eof());
        $this->assertEquals('', $this->stream->read(1));
    }

    /**
     * @covers ::getMetadata
     */
    public function testMetadata()
    {
        $this->assertEquals($this->stream->isSeekable(), $this->stream->getMetadata('seekable'));

        $actual = $this->stream->getMetadata();

        $stream = $this->stream->detach();

        $expected = stream_get_meta_data($stream);

        $this->assertEquals($expected, $actual);
    }
}
