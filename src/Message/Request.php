<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Message;

use Psr\Http\Message\OutgoingRequestInterface;
use Psr\Http\Message\StreamableInterface;

/**
 * Implementation of PSR HTTP Outgoing Request
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Request implements OutgoingRequestInterface
{
    use Message;

    /**
     * Method constants
     */
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const HEAD    = 'HEAD';
    const DELETE  = 'DELETE';
    const PATCH   = 'PATCH';
    const OPTIONS = 'OPTIONS';

    /**
     * @var string
     */
    private $method;

    /**
     * @var string|object
     */
    private $url;

    /**
     * {@inheritdoc}
     */
    public function setProtocolVersion($protocolVersion)
    {
        $this->protocolVersion = $protocolVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader($header, $value)
    {
        if (is_array($value)) {
            $value = array_map('strval', $value);
        } else {
            $value = [(string) $value];
        }

        $this->headers[strtolower($header)] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function addHeader($header, $value)
    {
        if (!$this->hasHeader($header)) {
            return $this->setHeader($header, $value);
        }

        $this->headers[strtolower($header)][] = (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function removeHeader($header)
    {
        if ($this->hasHeader($header)) {
            unset($this->headers[strtolower($header)]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setBody(StreamableInterface $body = null)
    {
        $this->body = $body;
    }
}
