<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Event;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use Exception;

/**
 * HTTP Request Failed event
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class RequestFailed extends RequestEvent
{
    const NAME = 'requestFailed';

    /**
     * @var Exception
     */
    private $exception;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Adapter $adapter
     * @param Request $request
     */
    public function __construct(Adapter $adapter, Request $request, Exception $exception)
    {
        $this->exception = $exception;

        parent::__construct($adapter, $request);
    }

    /**
     * Returns the Exception
     *
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Intercept the Request and set a Response
     *
     * @param Response $response
     */
    public function intercept(Response $response)
    {
        return $this->response = $response;
    }

    /**
     * Checks whether the request has been intercepted
     *
     * @return boolean
     */
    public function isIntercepted()
    {
        return isset($this->response);
    }

    /**
     * Returns the response (if any)
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
