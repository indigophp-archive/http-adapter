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
use stdClass;

/**
 * Tests for JSON Parser
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Http\Parser\Json
 * @group              Parser
 */
class JsonTest extends Test
{
    /**
     * Example response
     *
     * @var string
     */
    protected $response = '{"testObject": {"testProp": ["element1", "element2"]}}';

    /**
     * @covers ::__construct
     * @covers ::parse
     */
    public function testParse()
    {
        $parser = new Json;

        $expected = new stdClass;
        $expected->testObject = new stdClass;
        $expected->testObject->testProp = ['element1', 'element2'];

        $actual = $parser->parse($this->response);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::__construct
     * @covers ::parse
     */
    public function testParseAssoc()
    {
        $parser = new Json(true);

        $expected = [
            'testObject' => [
                'testProp' => [
                    'element1',
                    'element2',
                ],
            ],
        ];

        $actual = $parser->parse($this->response);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers            ::__construct
     * @covers            ::parse
     * @expectedException Indigo\Http\Exception\ParserException
     */
    public function testParseFailed()
    {
        $parser = new Json;

        $actual = $parser->parse('bad_data');
    }
}
