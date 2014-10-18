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
 * Message composer factory
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class MessageFactory
{
    /**
     * Creates a new Request
     *
     * @param mixed  $url
     * @param string $method
     * @param []     $options
     *
     * @return Request
     */
    public function createRequest(
        $url,
        $method = Request::GET,
        array $options = []
    ) {
        $request = new Response;

        $request->setUrl($url);
        $request->setMethod($method);

        $this->applyOptions($request, $options);

        return $request;
    }

    /**
     * Creates a new Response
     *
     * @param integer $statusCode
     * @param []      $options
     *
     * @return Response
     */
    public function createResponse($statusCode, array $options = [])
    {
        $response = new Response;

        $response->setStatusCode($statusCode);

        if (isset($options['reason_phrase'])) {
            $response->setReasonPhrase($options['reason_phrase']);

            unset($options['reason_phrase']);
        }

        $this->applyOptions($response, $options);

        return $response;
    }

    /**
     * Applies common options for Message
     *
     * @param Message $message
     * @param []      $options
     */
    public function applyOptions(Message $message, array $options)
    {
        $protocol_version = '1.1';
        $headers = [];
        $body = null;

        extract($options);

        $message->setProtocolVersion($protocol_version);

        $message->setHeaders($headers);

        if (!is_null($body)) {
            $body = $this->createStream($body);
        }

        $message->setBody($body);
    }

    /**
     * Creates a new Stream from various sources
     *
     * @param mixed $resource
     *
     * @return Stream
     */
    public function createStream($resource)
    {
        $type = gettype($resource);

        if ($type == 'string') {
            $stream = fopen('php://temp', 'r+');
            $stream = new Stream($stream);

            if ($resource !== '') {
                $stream->write($resource);
                $stream->seek(0);
            }

            return $stream;
        }

        if ($type == 'resource') {
            return new Stream($resource);
        }

        if ($resource instanceof StreamableInterface) {
            return $resource;
        }

        if ($type === 'object') {
            return $this->createStream((string) $resource);
        }

        throw new InvalidArgumentException('Invalid resource type: ' . $type);
    }
}
