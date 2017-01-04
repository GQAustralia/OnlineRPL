<?php

namespace GqAus\UserBundle\Services\Response;

use Symfony\Component\HttpFoundation\Response;

class ValidResponse extends AbstractHttpResponse
{
    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondSuccess($message = '')
    {
        return $this->setStatusCode(Response::HTTP_OK)->respondWithSuccess($message);
    }

    /**
     * @param string $message
     *
     * @return Response|static
     */
    public function respondCreated($message = '')
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respondWithSuccess($message);
    }

    /**
     * @param $messageDetail
     *
     * @return Response|static
     */
    private function respondWithSuccess($messageDetail)
    {
        $message = $this->buildValidMessage(
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
    private function buildValidMessage($title, $detail)
    {
        return [
            'result' => 'success',
            'details' => [
                'title' => $title,
                'message' => $detail
            ]
        ];
    }

}
