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

use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;

/**
 * Generic Client Adapter interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Adapter
{
    /**
     * Sends a request
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws RequestException If any exception is thrown by the underlying client
     */
    public function send(Request $request);
}
