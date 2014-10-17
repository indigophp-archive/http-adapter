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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws RequestException If any RequestException is thrown by the adapter
     */
    public function send(RequestInterface $request);
}
