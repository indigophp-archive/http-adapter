<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http;

/**
 * Generic Parser interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Parser
{
    /**
     * Parses a response string
     *
     * @param string $response
     *
     * @return mixed Based upon the API this can be anything
     *
     * @throws Indigo\Http\Exception\ParserException In case of any parsing error
     */
    public function parse($response);
}
