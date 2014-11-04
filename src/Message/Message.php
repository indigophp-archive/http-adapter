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
    public function getBody()
    {
        return $this->body;
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
}
