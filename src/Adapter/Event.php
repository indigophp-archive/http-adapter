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
use Indigo\Http\Event as Events;
use Psr\Http\Message\OutgoingRequestInterface as Request;

/**
 * Event Adapter decorator
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Event implements Adapter
{
    use Decorator;
    use \League\Event\EmitterTrait;

    /**
     * {@inheritdoc}
     */
    public function send(Request $request)
    {
        $this->emit(new Events\Before($this->adapter, $request));

        $response = $this->adapter->send($request);

        $this->emit(new Events\Complete($this->adapter, $request, $response));

        return $response;
    }
}
