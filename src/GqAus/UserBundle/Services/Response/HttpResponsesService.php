<?php

namespace GqAus\UserBundle\Services\Response;

class HttpResponsesService
{
    /**
     * @var ValidResponse
     */
    private $fractalResponse;

    /**
     * @var ErrorResponse
     */
    private $errorResponse;

    /**
     * ApiResponse constructor.
     * @param ValidResponse $fractalResponse
     * @param ErrorResponse $errorResponse
     */
    public function __construct(ValidResponse $fractalResponse, ErrorResponse $errorResponse)
    {
        $this->fractalResponse = $fractalResponse;
        $this->errorResponse = $errorResponse;
    }

    /**
     * @return ValidResponse
     */
    public function fractal()
    {
        return $this->fractalResponse;
    }

    /**
     * @return ErrorResponse
     */
    public function error()
    {
        return $this->errorResponse;
    }
}
