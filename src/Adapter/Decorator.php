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

/**
 * Generic Adapter decorator
 *
 * Should be used with an Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait Decorator
{
    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Returns the decorated adapter
     *
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
