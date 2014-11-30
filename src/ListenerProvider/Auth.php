<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\ListenerProvider;

use Indigo\Http\Event\RequestStarted;
use LogicException;
use RuntimeException;

/**
 * Provides authentication Listeners for a Request
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Auth extends Base
{
    /**
     * Authentication type constants
     */
    const BASIC  = 1;
    const DIGEST = 2;

    /**
     * {@inheritdoc}
     */
    protected $events = ['requestStarted'];

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * Authentication type
     *
     * @var integer
     */
    private $type;

    /**
     * @param string  $username
     * @param string  $password
     * @param integer $type
     */
    public function __construct($username, $password, $type = self::BASIC)
    {
        $this->username = $username;
        $this->password = $password;
        $this->type = $type;
    }

    /**
     * Adds Authentication details to the Request
     *
     * @param RequestStarted $event
     */
    public function requestStarted(RequestStarted $event)
    {
        $request = $event->getRequest();

        switch ($this->type) {
            case self::BASIC:
                $hash = base64_encode($this->username.':'.$this->password);
                $request->setHeader('Authentication', 'Basic '.$hash);
                break;

            case self::DIGEST:
                throw new LogicException('Not implemented yet');
                break;

            default:
                throw new RuntimeException('Unexpected authentication type');
                break;
        }
    }
}
