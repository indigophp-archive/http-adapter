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
 * Tests for Response
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Response
 */
class ResponseTest extends Test
{
    /**
     * @covers ::getStatusCode
     * @covers ::setStatusCode
     * @covers ::assertValidStatusCode
     */
    public function testStatusCode()
    {
        $response = new Response;

        $this->assertNull($response->getStatusCode());
        $this->assertNull($response->setStatusCode(200));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());

        $response->setStatusCode(599);
        $this->assertEquals('Unknown', $response->getReasonPhrase());
    }

    /**
     * @covers            ::setStatusCode
     * @covers            ::assertValidStatusCode
     * @expectedException InvalidArgumentException
     */
    public function testNonIntegerStatusCode()
    {
        $response = new Response;

        $response->setStatusCode('200');
    }

    /**
     * @covers            ::setStatusCode
     * @covers            ::assertValidStatusCode
     * @expectedException InvalidArgumentException
     */
    public function testOutOfRangeStatusCode()
    {
        $response = new Response;

        $response->setStatusCode(600);
    }

    /**
     * @covers ::getReasonPhrase
     * @covers ::setReasonPhrase
     */
    public function testReasonPhrase()
    {
        $response = new Response;

        $this->assertNull($response->getReasonPhrase());
        $this->assertNull($response->setReasonPhrase(''));
        $this->assertEquals('', $response->getReasonPhrase());
    }
}
