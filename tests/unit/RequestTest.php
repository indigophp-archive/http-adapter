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
 * Tests for Request
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Request
 */
class RequestTest extends Test
{
    /**
     * @covers ::getMethod
     * @covers ::setMethod
     */
    public function testMethod()
    {
        $request = new Request;

        $this->assertNull($request->getMethod());
        $this->assertNull($request->setMethod(Request::GET));
        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @covers ::getUrl
     * @covers ::setUrl
     */
    public function testUrl()
    {
        $request = new Request;

        $this->assertNull($request->getUrl());
        $this->assertNull($request->setUrl(''));
        $this->assertEquals('', $request->getUrl());
    }
}
