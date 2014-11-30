<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Listener;

use Indigo\Http\Event\RequestStarted;
use League\Url\Url;

/**
 * Provides API Key authentication Listeners for a Request
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ApiKey extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $events = ['requestStarted'];

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $parameter;

    /**
     * @param integer $type
     */
    public function __construct($key, $parameter = 'key')
    {
        $this->key = $key;
        $this->parameter = $parameter;
    }

    /**
     * Adds Authentication details to the Request
     *
     * @param RequestStarted $event
     */
    public function requestStarted(RequestStarted $event)
    {
        $request = $event->getRequest();

        $url = Url::createFromUrl($request->getUrl());
        $query = $url->getQuery();

        $query[$this->parameter] = $this->key;

        $request->setUrl((string) $url);
    }
}
