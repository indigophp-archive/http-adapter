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

use Indigo\Http\Event\Before;
use LogicException;
use RuntimeException;

/**
 * Provides authentication listeners for a request
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Auth extends ListenerProvider
{
    /**
     * Authentication type constants
     */
    const BASIC  = 1;
    const DIGEST = 2;

    /**
     * {@inheritdoc}
     */
    protected $events = ['before'];

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
     * @param integer $type
     */
    public function __construct($username, $password, $type = self::BASIC)
    {
        $this->username = $username;
        $this->password = $password;
        $this->type = $type;
    }

    /**
     * Before event listener
     *
     * @param Before $event
     */
    public function before(Before $event)
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
