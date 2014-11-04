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
use InvalidArgumentException;

/**
 * Implementation of PSR HTTP Stream
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Stream implements StreamableInterface
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @var boolean
     */
    private $seekable = false;

    /**
     * @var boolean
     */
    private $writable = false;

    /**
     * @var boolean
     */
    private $readable = false;

    /**
     * @var []
     */
    private $meta = [];

    /** @var array Hash of readable and writable stream types (stolen from guzzle) */
    private static $readWriteHash = [
        'read' => [
            'r' => true, 'w+' => true, 'r+' => true, 'x+' => true, 'c+' => true,
            'rb' => true, 'w+b' => true, 'r+b' => true, 'x+b' => true,
            'c+b' => true, 'rt' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a+' => true
        ],
        'write' => [
            'w' => true, 'w+' => true, 'rw' => true, 'r+' => true, 'x+' => true,
            'c+' => true, 'wb' => true, 'w+b' => true, 'r+b' => true,
            'x+b' => true, 'c+b' => true, 'w+t' => true, 'r+t' => true,
            'x+t' => true, 'c+t' => true, 'a' => true, 'a+' => true
        ]
    ];

    /**
     * @param resource $stream
     */
    public function __construct($stream)
    {
        if (!is_resource($stream)) {
            throw new InvalidArgumentException('Stream must be a resource');
        }

        $this->stream = $stream;
        $this->meta = stream_get_meta_data($stream);
        $this->seekable = $this->meta['seekable'];
        $this->writable = array_key_exists($this->meta['mode'], self::$readWriteHash['write']);
        $this->readable = array_key_exists($this->meta['mode'], self::$readWriteHash['read']);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->stream ? stream_get_contents($this->stream, -1, 0) : '';
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        $this->detach();
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        $stream = $this->stream;

        $this->stream = null;
        $this->seekable = $this->writable = $this->readable = false;
        $this->meta = [];

        return $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        return $this->stream ? ftell($this->stream) : false;
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        return $this->stream && feof($this->stream);
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        return $this->seekable;
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        return $this->seekable ? fseek($this->stream, $offset, $whence) === 0 : false;
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return $this->writable;
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
        return $this->writable ? fwrite($this->stream, $string) : false;
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        return $this->readable;
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        return $this->readable ? fread($this->stream, $length) : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        return $this->stream ? stream_get_contents($this->stream) : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
        if (is_null($key)) {
            return $this->meta;
        }

        return array_key_exists($key, $this->meta) ? $this->meta[$key] : null;
    }
}
