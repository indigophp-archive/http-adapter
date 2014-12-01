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

/**
 * Request event base
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class RequestEvent extends DomainEvent
{
    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Adapter $adapter
     * @param Request $request
     */
    public function __construct(Adapter $adapter, Request $request)
    {
        $this->adapter = $adapter;
        $this->request = $request;
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
}
