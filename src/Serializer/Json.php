<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Serializer;

use Indigo\Http\Serializer;

/**
 * Implementation of JSON Serializer
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Json implements Serializer
{
    /**
     * {@inheritdoc}
     */
    public function serialize($request);
}
