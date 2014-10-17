<?php

/*
 * This file is part of the Indigo Some package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Adapter;

use Codeception\TestCase\Test;

/**
 * Tests for Mock Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Adapter\Mock
 */
class MockTest extends Test
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $callable = function() {};
        $adapter = new Mock($callable);

        $this->assertAttributeSame($callable, 'response', $adapter);
    }

    /**
     * @covers ::setResponse
     */
    public function testSetResponse()
    {
        $callable = function() {};
        $adapter = new Mock;

        $adapter->setResponse($callable);

        $this->assertAttributeSame($callable, 'response', $adapter);
    }

    /**
     * @covers ::send
     */
    public function testSend()
    {
        $request = \Mockery::mock('Psr\\Http\\Message\\RequestInterface');
        $response = \Mockery::mock('Psr\\Http\\Message\\ResponseInterface');
        $adapter = new Mock($response);

        $received = $adapter->send($request);

        $this->assertSame($response, $received);
    }

    /**
     * @covers            ::send
     * @expectedException Indigo\Http\Exception\AdapterException
     */
    public function testSendInvalidResponse()
    {
        $request = \Mockery::mock('Psr\\Http\\Message\\RequestInterface');
        $adapter = new Mock;

        $adapter->send($request);
    }
}
