<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * Fractal manager instance.
     *
     * @var Manager
     */
    protected $fractal;

    /**
     * Set fractal Manager instance.
     *
     * @param Manager $fractal
     * @return void
     */
    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Send custom data response.
     *
     * @param $status
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCustomResponse($status, $message)
    {
        return response()->json(['status' => $status, 'message' => $message], $status);
    }

    /**
     * Wrapper for error responses.
     *
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendErrorResponse($response)
    {
        return response()->json(['error' => $response], $response['status']);
    }

    /**
     * Send a custom error response.
     *
     * @param $status
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCustomErrorResponse($status, $message)
    {
        $response = ['status' => $status, 'message' => $message];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when api user provides not existing fields.
     *
     * @param $errors
     * @return mixed
     */
    public function sendUnknownFieldResponse($errors)
    {
        $response = ['status' => Response::HTTP_BAD_REQUEST, 'unknown_fields' => $errors];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a user provides not existing filter.
     *
     * @param $errors
     * @return mixed
     */
    public function sendInvalidFilterResponse($errors)
    {
        $response = ['status' => Response::HTTP_BAD_REQUEST, 'invalid_filters' => $errors];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a user does not use JSON as content-type.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInvalidContentTypeResponse()
    {
        $response = ['status' => Response::HTTP_BAD_REQUEST, 'message' => 'Use of JSON as content-type is mandatory'];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a user provide incorrect data type for the field.
     *
     * @param $errors
     * @return mixed
     */
    public function sendInvalidFieldResponse($errors)
    {
        $response = ['status' => Response::HTTP_UNPROCESSABLE_ENTITY, 'invalid_fields' => $errors];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a user tries to execute a forbidden action.
     *
     * @return string
     */
    public function sendForbiddenResponse()
    {
        $response = ['status' => Response::HTTP_FORBIDDEN, 'message' => 'Forbidden'];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a user is unauthorized.
     *
     * @return string
     */
    public function sendUnAuthorizedResponse()
    {
        $response = ['status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Client is not authorized to perform this request'];

        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when a resource is not found.
     *
     * @param string $message
     * @return string
     */
    public function sendNotFoundResponse($message = '')
    {
        if (empty($message)) {
            $message = 'The requested resource was not found';
        }

        $response = ['status' => Response::HTTP_NOT_FOUND, 'message' => $message];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send this response when there is no content to be displayed.
     *
     * @return string
     */
    public function sendNoContentResponse()
    {
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Send this response when a user tries to access a feature that is not yet implemented.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotYetImplementedResponse($message = '')
    {
        if (empty($message)) {
            $message = 'This feature is not yet implemented';
        }

        $response = ['status' => Response::HTTP_NOT_IMPLEMENTED, 'message' => $message];
        return $this->sendErrorResponse($response);
    }

    /**
     * Send empty data response.
     *
     * @return string
     */
    public function sendEmptyDataResponse()
    {
        return response()->json(['data' => new \StdClass()], Response::HTTP_NO_CONTENT);
    }
}