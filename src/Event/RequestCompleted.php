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
 * HTTP Request Completed event
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class RequestCompleted extends RequestEvent
{
    const NAME = 'requestCompleted';

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Adapter  $adapter
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Adapter $adapter, Request $request, Response $response)
    {
        $this->response = $response;

        parent::__construct($adapter, $request);
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
}
