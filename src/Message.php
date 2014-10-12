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

use Psr\Http\Message\StreamableInterface;

/**
 * Implementation of PSR HTTP Message
 *
 * Classes using this trait should implement Psr\Http\Message\MessageInterface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait Message
{
    /**
     * @var string
     */
    private $protocolVersion = '1.1';

    /**
     * @var []
     */
    private $headers = [];

    /**
     * @var StreamableInterface
     */
    private $body;

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

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
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function setBody(StreamableInterface $body = null)
    {
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($header)
    {
        return array_key_exists(strtolower($header), $this->headers);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($header)
    {
        return implode(',', $this->getHeaderAsArray($header));
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderAsArray($header)
    {
        $value = [];

        if ($this->hasHeader($header)) {
            $value = $this->headers[strtolower($header)];
        }

        return $value;
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
    public function setHeaders(array $headers)
    {
        $this->headers = [];

        foreach ($headers as $header => $value) {
            $this->setHeader($header, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addHeader($header, $value)
    {
        $value = (string) $value;

        if (!$this->hasHeader($header)) {
            return $this->setHeader($header, $value);
        }

        $this->headers[strtolower($header)][] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
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
}
