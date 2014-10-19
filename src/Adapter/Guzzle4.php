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
use Psr\Http\Message\RequestInterface as Request;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

/**
 * Guzzle 4 Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Guzzle4 implements Adapter
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
            $response = $this->client->send($request);
        } catch (GuzzleRequestException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->transformResponse($response);
    }

    /**
     * Creates a Guzzle Request
     *
     * @param Request $request
     *
     * @return GuzzleHttp\Message\RequestInterface
     */
    private function transformRequest(Request $request)
    {
        $method = $request->getMethod();
        $url = $request->getUrl();
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
     * @param GuzzleHttp\Message\ResponseInterface $response
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

        if ($body = $response->getBody()) {
            $body = new Stream($body->detach());
            $transformed->setBody($body);
        }

        $transformed->setProtocolVersion($response->getProtocolVersion());

        return $transformed;
    }
}
