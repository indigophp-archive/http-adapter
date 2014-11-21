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
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\RequestException as GuzzleRequestException;

/**
 * Guzzle 3 Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Guzzle3 implements Adapter
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request)
    {
        $request = $this->transformRequest($request);

        try {
            $response = $this->transformResponse($this->client->send($request));
        } catch (GuzzleRequestException $e) {
            throw RequestException::create($request, $response, $e);
        }

        return $response;
    }

    /**
     * Creates a Guzzle Request
     *
     * @param Request $request
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    private function transformRequest(Request $request)
    {
        $method = $request->getMethod();
        $url = (string) $request->getUrl();
        $options = [
            'version' => $request->getProtocolVersion(),
            'headers' => $request->getHeaders(),
        ];

        if ($body = $request->getBody()) {
            $options['body'] = $body->detach();
        }

        return $this->client->createRequest($method, $url, $options);
    }

    /**
     * Returns a Response
     *
     * @param \Guzzle\Http\Message\Response $response
     *
     * @return Response
     */
    private function transformResponse($response)
    {
        if (is_null($response)) {
            return;
        }

        if ($body = $response->getBody()) {
            $body = new Stream($body->getStream());
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
