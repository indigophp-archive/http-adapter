<?php

/*
 * This file is part of the Indigo Some package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Parser;

use Codeception\TestCase\Test;

/**
 * Tests for XML Parser
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Parser\Xml
 * @group              Parser
 */
class XmlTest extends Test
{
    /**
     * Example response
     *
     * @var string
     */
    protected $response = '<element><child>value</child></element>';

    /**
     * @covers ::__construct
     * @covers ::parse
     * @covers ::normalizeResponse
     * @covers ::libxmlSettings
     */
    public function testParse()
    {
        $parser = new Xml;

        $actual = $parser->parse($this->response);

        $this->assertEquals('value', $actual->child);
    }

    /**
     * @covers            ::__construct
     * @covers            ::parse
     * @covers            ::libxmlSettings
     * @expectedException Indigo\Http\Exception\ParserException
     */
    public function testParseFailed()
    {
        $parser = new Xml;

        $actual = $parser->parse(true);
    }
}
