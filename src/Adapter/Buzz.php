<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Adapter;

use Indigo\Http\Adapter;
use Indigo\Http\Stream;
use Indigo\Http\Response;
use Indigo\Http\Exception\RequestException;
use Psr\Http\Message\RequestInterface as Request;
use Buzz\Browser;
use Buzz\Exception\RequestException as BuzzRequestException;

/**
 * Buzz Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Buzz implements Adapter
{
    /**
     * @var Browser
     */
    private $browser;

    /**
     * @param Browser $browser
     */
    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request)
    {
        $request = $this->transformRequest($request);

        try {
            $response = $this->browser->send($request);
        } catch (BuzzRequestException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->transformResponse($response);
    }

    /**
     * Creates a Buzz Request
     *
     * @param Request $request
     *
     * @return Butt\Message\RequestInterface
     */
    private function transformRequest(Request $request)
    {
        $method = $request->getMethod();
        $url = $request->getUrl();

        $transformed = $this->browser->getMessageFactory()->createRequest($method, $url);

        $transformed->setProtocolVersion($request->getProtocolVersion());
        $transformed->setHeaders($request->getHeaders());

        if ($body = $request->getBody()) {
            $transformed->setContent((string) $body);
        }


        return $transformed;
    }

    /**
     * Returns a Response
     *
     * @param Buzz\Message\Response $response
     *
     * @return Response
     */
    private function transformResponse($response)
    {
        $transformed = new Response;

        $transformed->setStatusCode($response->getStatusCode());

        foreach ($response->getHeaders() as $header => $value) {
            $transformed->setHeader($header, $value);
        }

        if ($body = $response->getContent()) {
            $body = $this->createStream($content);
            $transformed->setBody($body);
        }

        $transformed->setProtocolVersion($response->getProtocolVersion());

        return $transformed;
    }

    /**
     * Creates a new Stream from string
     *
     * @param string $resource
     *
     * @return Stream
     */
    public function createStream($resource)
    {
        $stream = fopen('php://temp', 'r+');
        $stream = new Stream($stream);

        if (!empty($resource)) {
            $stream->write($resource);
            $stream->seek(0);
        }

        return $stream;
    }
}
