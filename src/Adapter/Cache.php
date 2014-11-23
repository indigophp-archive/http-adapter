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
use Stash\Interfaces\ItemInterface as Item;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
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
        // We hash it because / is not enabled in Stash
        $hash = md5($request->getUrl());

        $item = $this->getItem($hash);
        $cachedResponse = $item->get();

        // Do we have a cache?
        if (!$item->isMiss()) {
            $this->setModifiedSince($request, $item);
            $this->setEtag($request, $cachedResponse);
        }

        $response = $this->adapter->send($request);

        // Is the content modified?
        if ($response->getStatusCode() !== 304) {
            $item->set($response);
            $cachedResponse = $response;
        }

        return $cachedResponse;
    }

    /**
     * Sets If-Modified-Since header if creation time is available
     *
     * @param Request $request
     * @param Item    $item
     */
    private function setModifiedSince(Request $request, Item $item)
    {
        if ($modifiedAt = $item->getCreation()) {
            $modifiedAt->setTimezone(new DateTimeZone('GMT'));

            $date = sprintf('%s GMT', $modifiedAt->format('l, d-M-y H:i:s'));

            $request->addHeader('If-Modified-Since', $date);
        }
    }

    /**
     * Sets ETag if available in the cached response
     *
     * @param Request  $request
     * @param Response $cachedResponse
     */
    private function setEtag(Request $request, Response $cachedResponse)
    {
        if ($etag = $cachedResponse->getHeader('ETag')) {
            $request->addHeader('If-None-Match', $etag);
        }
    }
}
