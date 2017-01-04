<?php

namespace GqAus\UserBundle\Services\Response;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponse extends AbstractHttpResponse
{
    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondErrorNotFound($message = '')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondBadRequest($message = '')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondUnprocessableEntity($message = '')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * @param $messageDetail
     *
     * @return Response|static
     */
    private function respondWithError($messageDetail)
    {
        $message = $this->buildErrorMessage(
            Response::$statusTexts[$this->getStatusCode()],
            $messageDetail
        );

        return $this->outputToJson($message);
    }

    /**
     * @param string $title
     * @param string $detail
     *
     * @return array
     */
    private function buildErrorMessage($title, $detail)
    {
        return [
            'result' => 'error',
            'details' => [
                'title' => $title,
                'message' => $detail
            ]
        ];
    }
}
