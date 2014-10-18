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

use Psr\Http\Message\MessageInterface;

/**
 * Message Stub
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Message implements MessageInterface
{
    use \Indigo\Http\Message;
}
