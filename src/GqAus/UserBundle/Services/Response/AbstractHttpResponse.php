<?php

namespace GqAus\UserBundle\Services\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractHttpResponse
{
    const CONTENT_TYPE = 'application/json';

    /**
     * array @var
     */
    protected $meta = [];

    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * @var array
     */
    protected $headers = ['Content-Type' => self::CONTENT_TYPE];

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode = Response::HTTP_OK)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @param array $meta
     *
     * @return $this
     */
    public function withMeta($meta = [])
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param $message
     *
     * @return JsonResponse|static
     */
    final public function outputToJson($message)
    {
        return JsonResponse::create($message, $this->getStatusCode(), $this->getHeaders());
    }
}
