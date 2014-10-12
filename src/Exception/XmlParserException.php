<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Exception;

use LibXMLError;
use Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class XmlParserException extends ParserException
{
    /**
     * @var LibXMLError
     */
    private $error;

    public function __construct($message = '', Exception $previous = null, LibXMLError $error = null)
    {
        parent::__construct($message, 0, $previous);

        $this->error = $error;
    }

    /**
     * Returns the XML error
     *
     * @return LibXMLError
     */
    public function getError()
    {
        return $this->error;
    }
}
