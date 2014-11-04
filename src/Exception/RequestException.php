<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Exception;

use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class RequestException extends \RuntimeException
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param string    $message
     * @param Request   $request
     * @param Response  $response
     * @param Exception $previous
     */
    public function __construct(
        $message,
        Request $request,
        Response $response = null,
        Exception $previous = null
    ) {
        $code = $response ? $response->getStatusCode() : 0;

        parent::__construct($message, $code, $previous);

        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Creates a new exception based on input data
     *
     * @param Request   $request
     * @param Response  $response
     * @param Exception $previous
     */
    public static function create(
        Request $request,
        Response $response = null,
        Exception $previous = null
    ) {
        if (!$response) {
            return new self('Error completing request', $request, null, $previous);
        }

        $code = $response->getStatusCode();

        switch ($code[0]) {
            case '4':
                $message = 'Client Error';
                break;
            case '5':
                $message = 'Server Error';
                break;
            default:
                $message = 'Unknown Error';
                break;
        }

        return new self($message, $request, $response, $previous);
    }

    /**
     * Returns the Request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns the Response
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
