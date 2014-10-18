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
 * Generic Serializer interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Serializer
{
    /**
     * Serializes a request for the API backend
     *
     * @param mixed $request
     *
     * @return string
     */
    public function serialize($request);

    /**
     * Checks whether the passed request can be serialized by self
     *
     * @param mixed $request
     *
     * @return boolean
     */
    public function serializes($request);
}
