<?php

/*
 * This file is part of the Indigo HTTP package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Stub;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;

/**
 * Adapter Decorator Stub
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Decorator implements Adapter
{
    use \Indigo\Http\Adapter\Decorator;

    public function send(Request $request)
    {
        return $this->adapter->send($request);
    }
}
