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

use Psr\Http\Message\OutgoingRequestInterface as Request;
use League\Url\UrlImmutable;
use League\Url\Url;

/**
 * Implementation of generic HTTP Client
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Client
{
    /**
     * HTTP Client Adapter
     *
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var UrlImmutable
     */
    protected $baseUrl;

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter, $baseUrl = null)
    {
        $this->adapter = $adapter;
        $this->setBaseUrl($baseUrl);
    }

    /**
     * Returns the base URL
     *
     * @return UrlImmutable
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Sets the base URL
     *
     * @param string|Url|UrlImmutable $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = UrlImmutable::createFromUrl($baseUrl);
    }

    /**
     * Sends a request and returns it's body
     *
     * @param Request $request
     *
     * @return string
     */
    public function send(Request $request)
    {
        $response = $this->adapter->send($request);

        return $response->getBody()->getContents();
    }

    /**
     * Creates a request
     *
     * @param string      $method
     * @param string|null $url
     * @param array       $options
     *
     * @return Request
     */
    public function createRequest($method, $url = null, array $options = [])
    {
        $protocol_version = '1.1';
        $body = null;
        $headers = [];

        extract($options);

        $request = new Message\Request;

        $request->setMethod($method);
        $request->setUrl($url ? (string) $this->createUrl($url) : (string) $this->baseUrl);
        $request->setProtocolVersion($protocol_version);

        if (isset($body)) {
            $body = Stream::create($body);
            $request->setBody($body);
        }

        foreach ($headers as $key => $value) {
            $request->setHeader($key, $value);
        }

        return $request;
    }

    /**
     * Creates a URL using the base URL
     *
     * @param string|null|Url $url
     *
     * @return Url
     */
    protected function createUrl($url)
    {
        // is absolute URL?
        if (strpos($url, '://')) {
            return Url::createFromUrl($url);
        }

        // only query and path matters in relative url
        $url = Url::createFromUrl($url);
        $query = $this->baseUrl->getQuery();
        $path = $this->baseUrl->getPath();

        $query->modify($url->getQuery());
        $path->append($url->getPath());

        return $this->baseUrl->setQuery($query)->setPath($path);
    }

    /**
     * Creates and executes a GET request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function get($url = null, array $options = [])
    {
        return $this->send($this->createRequest('GET', $url, $options));
    }

    /**
     * Creates and executes a POST request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function post($url = null, array $options = [])
    {
        return $this->send($this->createRequest('POST', $url, $options));
    }

    /**
     * Creates and executes a PUT request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function put($url = null, array $options = [])
    {
        return $this->send($this->createRequest('PUT', $url, $options));
    }

    /**
     * Creates and executes a HEAD request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function head($url = null, array $options = [])
    {
        return $this->send($this->createRequest('HEAD', $url, $options));
    }

    /**
     * Creates and executes a DELETE request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function delete($url = null, array $options = [])
    {
        return $this->send($this->createRequest('DELETE', $url, $options));
    }

    /**
     * Creates and executes a PATCH request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function patch($url = null, array $options = [])
    {
        return $this->send($this->createRequest('PATCH', $url, $options));
    }

    /**
     * Creates and executes a OPTIONS request
     *
     * @param mixed $url
     * @param array $options
     *
     * @return string
     */
    public function options($url = null, array $options = [])
    {
        return $this->send($this->createRequest('OPTIONS', $url, $options));
    }
}
