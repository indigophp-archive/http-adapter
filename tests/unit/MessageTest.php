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
 * Tests for Message
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Message
 */
class MessageTest extends Test
{
    /**
     * @covers ::getProtocolVersion
     * @covers ::setProtocolVersion
     */
    public function testProtocolVersion()
    {
        $message = new Request;

        $this->assertEquals('1.1', $message->getProtocolVersion());
        $this->assertNull($message->setProtocolVersion('1.0'));
        $this->assertEquals('1.0', $message->getProtocolVersion());
    }

    /**
     * @covers ::getBody
     * @covers ::setBody
     */
    public function testBody()
    {
        $message = new Response;

        $body = null;

        $this->assertNull($message->getBody());
        $this->assertNull($message->setBody($body));
        $this->assertSame($body, $message->getBody());
        $this->assertNull($message->setBody(null));
        $this->assertNull($message->getBody());
    }

    /**
     * @covers ::getHeaders
     * @covers ::hasHeader
     * @covers ::getHeader
     * @covers ::getHeaderAsArray
     * @covers ::setHeader
     * @covers ::setHeaders
     * @covers ::addHeader
     * @covers ::addHeaders
     * @covers ::removeHeader
     */
    public function testHeaders()
    {
        $message = new Request;

        $this->assertEquals([], $message->getHeaders());
        $this->assertFalse($message->hasHeader('foo'));
        $this->assertNull($message->setHeader('foo', 'bar'));
        $this->assertTrue($message->hasHeader('foo'));
        $this->assertEquals('bar', $message->getHeader('foo'));
        $this->assertNull($message->addHeader('foo', 'another_bar'));
        $this->assertEquals('bar,another_bar', $message->getHeader('foo'));
        $this->assertEquals(['bar', 'another_bar'], $message->getHeaderAsArray('foo'));
        $message->setHeaders([]);
        $this->assertEquals([], $message->getHeaders());
        $this->assertNull($message->addHeaders(['foo' => 'bar']));
        $this->assertEquals(['bar'], $message->getHeaderAsArray('foo'));
        $this->assertNull($message->removeHeader('foo'));
        $this->assertEquals([], $message->getHeaders());
        $message->setHeaders(['foo' => ['bar', 'another_bar']]);
        $this->assertEquals(['bar', 'another_bar'], $message->getHeaderAsArray('foo'));
    }
}
