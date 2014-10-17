<?php

/*
 * This file is part of the Indigo HTTP Adapter package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Http\Parser;

use Indigo\Http\Parser;
use Indigo\Http\Exception\XmlParserException;
use SimpleXMLElement;
use Exception;

/**
 * Implementation of XML Parser
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Xml implements Parser
{
    /**
     * @var integer
     */
    private $options = LIBXML_NONET;

    /**
     * @var string
     */
    private $ns = '';

    /**
     * @var boolean
     */
    private $isPrefix = false;

    /**
     * @param integer $options
     * @param string  $ns
     * @param boolean $isPrefix
     */
    public function __construct($options = LIBXML_NONET, $ns = '', $isPrefix = false)
    {
        $this->options = $options;
        $this->ns = $ns;
        $this->isPrefix = $isPrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($response)
    {
        $disableEntities = libxml_disable_entity_loader(true);
        $internalErrors = libxml_use_internal_errors(true);

        try {
            $data = new SimpleXMLElement(
                $this->normalizeResponse($response),
                $this->options,
                false,
                $this->ns,
                $this->isPrefix
            );

            libxml_disable_entity_loader($disableEntities);
            libxml_use_internal_errors($internalErrors);
        } catch (Exception $e) {
            libxml_disable_entity_loader($disableEntities);
            libxml_use_internal_errors($internalErrors);

            throw new XmlParserException(
                'Unable to parse response body into XML: ' . $e->getMessage(),
                $e,
                $this->getLastError()
            );
        }

        return $data;
    }

    /**
     * Normalize response value
     *
     * @param mixed $response
     *
     * @return string
     */
    private function normalizeResponse($response)
    {
        $response = (string) $response;

        if (empty($response)) {
            $response = '<root />';
        }

        return $response;
    }

    /**
     * Returns last error
     *
     * @return string|null
     */
    private function getLastError()
    {
        return (libxml_get_last_error()) ?: null;
    }
}
