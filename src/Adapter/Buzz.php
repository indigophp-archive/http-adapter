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
use Indigo\Http\Message\Response;
use Indigo\Http\Exception\RequestException;
use Psr\Http\Message\OutgoingRequestInterface as Request;
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
        $buzzRequest = $this->transformRequest($request);
        $response = null;

        try {
            $response = $this->transformResponse($this->browser->send($buzzRequest));
        } catch (BuzzRequestException $e) {
            throw RequestException::create($request, $response, $e);
        }

        return $response;
    }

    /**
     * Creates a Buzz Request
     *
     * @param Request $request
     *
     * @return \Buzz\Message\RequestInterface
     */
    private function transformRequest(Request $request)
    {
        $method = $request->getMethod();
        $url = (string) $request->getUrl();

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
     * @param \Buzz\Message\MessageInterface $response
     *
     * @return Response
     */
    private function transformResponse($response = null)
    {
        if (is_null($response)) {
            return;
        }

        if ($body = $response->getContent()) {
            $body = Stream::create($body);
        } else {
            $body = null;
        }

        $transformed = new Response(
            $response->getStatusCode(),
            null,
            $response->getHeaders(),
            $body,
            $response->getProtocolVersion()
        );

        return $transformed;
    }
}
