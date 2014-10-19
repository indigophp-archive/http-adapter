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
use Stash\Interfaces\PoolInterface;
use Psr\Http\Message\RequestInterface as Request;
use DateTimeZone;

/**
 * Cache Adapter decorator
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cache implements Adapter, PoolInterface
{
    use Decorator;
    use \Stash\PoolTrait;

    /**
     * {@inheritdoc}
     */
    public function send(Request $request)
    {
        $item = $this->getItem($request->getUrl());

        // Do we have a cache?
        if (!$item->isMiss()) {
            $cached = $item->get();

            // Do we know the creation time?
            if ($modifiedAt = $item->getCreation()) {
                $modifiedAt->setTimezone(new DateTimeZone('GMT'));

                $date = sprintf('%s GMT', $modifiedAt->format('l, d-M-y H:i:s'));

                $request->addHeader('If-Modified-Since', $date);
            }

            // Do we have an ETag?
            if ($etag = $cached->getHeader('ETag')) {
                $request->addHeader('If-None-Match', $etag);
            }
        }

        $response = $this->adapter->send($request);

        // Is the content modified?
        if ($response->getStatusCode() !== 304) {
            $item->set($response);
            $cached = $response;
        }

        return $cached;
    }
}
