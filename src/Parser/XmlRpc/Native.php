<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Parser\XmlRpc;

use Indigo\Http\Parser;
use Indigo\Http\Exception\XmlParserException;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Implementation of XML Parser
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Native implements Parser
{
    /**
     * @var string
     */
    private $encoding = 'UTF-8';

    /**
     * @var DateTimeZone
     */
    private $timezone;

    /**
     * @param DateTimeZone $timezone
     * @param string       $encoding
     */
    public function __construct(DateTimeZone $timezone = null, $encoding = 'UTF-8')
    {
        $this->timezone = $timezone;
        $this->encoding = $encoding;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($response)
    {
        $data = xmlrpc_decode($response, $this->encoding);

        $this->processData($data);

        if (is_array($data)) {
            reset($data);
        }

        if (xmlrpc_is_fault($data)) {
            throw new XmlRpcFaultException();
        }

        return $data;
    }

    /**
     * Recursively processes the data and converts it to value objects
     *
     * @param mixed $data
     */
    private function processData(&$data)
    {
        if (is_object($data)) {
            $type = $data->{'xmlrpc_type'};

            switch ($type) {
                case 'datetime':
                    $data = DateTime::createFromFormat(
                        'Ymd\TH:i:s',
                        $data->scalar,
                        $this->timezone
                    );
                    break;
                case 'base64':
                    # code...
                    break;
            }
        } elseif (is_array($data)) {
            foreach ($data as &$d) {
                $this->processData($d)
            }
        }
    }
}
