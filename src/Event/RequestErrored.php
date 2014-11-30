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

/**
 * HTTP Request Errored event
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Error extends DomainEvent
{
    const NAME = 'requestErrored';

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * Checks whether the error is handled
     *
     * @var boolean
     */
    private $handled;

    /**
     * @param Adapter  $adapter
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Adapter $adapter, Request $request, Response $response)
    {
        $this->adapter = $adapter;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Returns the Adapter
     *
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Returns the Request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns the Response
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the handled status
     *
     * @param boolean $handled
     */
    public function handle($handled = true)
    {
        $this->handled = (bool) $handled;
    }

    /**
     * Checks whether the error is handled
     *
     * @return boolean
     */
    public function isHandled()
    {
        return $this->handled;
    }
}
