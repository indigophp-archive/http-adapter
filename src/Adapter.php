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

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Generic Client Adapter interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Adapter
{
    /**
     * Sends a request
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws RequestException If any RequestException is thrown by the adapter
     */
    public function send(Request $request);

    /**
     * Sends a GET Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function get($url = null, array $options = []);

    /**
     * Sends a POST Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function post($url = null, array $options = []);

    /**
     * Sends a PUT Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function put($url = null, array $options = []);

    /**
     * Sends a HEAD Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function head($url = null, array $options = []);

    /**
     * Sends a DELETE Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function delete($url = null, array $options = []);

    /**
     * Sends a PATCH Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function patch($url = null, array $options = []);

    /**
     * Sends a OPTIONS Request
     *
     * @param mixed $url
     * @param []    $options
     *
     * @return Response
     */
    public function options($url = null, array $options = []);
}
