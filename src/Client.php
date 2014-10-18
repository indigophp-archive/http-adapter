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

/**
 * Generic HTTP Client implementation
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Client
{
    protected $adapter;
    protected $messageFactory;

    /**
     * @param Adapter         $adapter
     * @param MessageFactory  $messageFactory
     */
    public function __construct(Adapter $adapter, MessageFactory $messageFactory = null)
    {
        $this->adapter = $adapter;
        $this->messageFactory = $messageFactory;
    }

    public function parseResponse()
    {
        # code...
    }
}
