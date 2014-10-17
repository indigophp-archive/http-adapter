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
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RuntimeException;

/**
 * Mock Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Mock implements Adapter
{
    /**
     * Response object or callable which handles the request
     *
     * @var Response|callable
     */
    private $response;

    /**
     * @param Response|callable $response
     */
    public function __construct($response = null)
    {
        $this->setResponse($response);
    }

    /**
     * Sets the mocked response
     *
     * @param Response|callable $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Request $request)
    {
        $response = is_callable($this->response) ? call_user_func($this->response, $request) : $this->response;

        if (!$response instanceof Response) {
            throw new RuntimeException('Mocked response is invalid');
        }

        return $response;
    }
}
