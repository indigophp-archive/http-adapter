<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Parser;

use Indigo\Http\Parser;
use Indigo\Http\Exception\ParserException;

/**
 * Implementation of JSON Parser
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Json implements Parser
{
    /**
     * JSON Error Constants
     */
    const JSON_ERROR_DEPTH = 'Maximum stack depth exceeded';
    const JSON_ERROR_STATE_MISMATCH = 'Underflow or the modes mismatch';
    const JSON_ERROR_CTRL_CHAR = 'Unexpected control character found';
    const JSON_ERROR_SYNTAX = 'Syntax error, malformed JSON';
    const JSON_ERROR_UTF8 = 'Malformed UTF-8 characters, possibly incorrectly encoded';

    /**
     * @var boolean
     */
    private $assoc = false;

    /**
     * @var integer
     */
    private $depth = 512;

    /**
     * @var integer
     */
    private $options = 0;

    /**
     * @param boolean $assoc
     * @param integer $depth
     * @param integer $options
     */
    public function __construct($assoc = false, $depth = 512, $options = 0)
    {
        $this->assoc = $assoc;
        $this->depth = $depth;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($response)
    {
        $data = json_decode($response, $this->assoc, $this->depth, $this->options);

        if ($last = json_last_error() !== JSON_ERROR_NONE) {
            $message = 'Unable to parse JSON data: ';
            $message .= defined('self::'.$last) ? self::$last : 'Unknown error';

            throw new ParserException($message);
        }

        return $data;
    }
}
