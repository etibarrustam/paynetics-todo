<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiResponse extends JsonResponse
{
    /**
     * API response instance.
     * Added HTTP 200 status code to all responses. Due to task requirements.
     * @param JsonResource|null $resource
     * @param array $headers
     * @param int $options
     */
    public function __construct(JsonResource $resource = null, array $headers = [], int $options = 0)
    {
        $this->encodingOptions = $options;

        parent::__construct([
            'code' => ApiCode::SUCCESS,
            'data' => $resource,
            'validation_errors' => (object) [],
        ], Response::HTTP_OK, $headers);
    }

    /**
     * Fail response.
     * @param array $errors
     * @return $this
     */
    final public function fail(array $errors = []): static
    {
        $this->setApiCode(ApiCode::ERROR);
        $this->setErrors($errors);

        return $this;
    }

    /**
     * Set custom status code.
     */
    final public function setApiCode(ApiCode $code): self
    {
        $data = (array) $this->getData();
        $this->setData(Arr::set($data, 'code', $code));

        return $this;
    }

    /**
     * Set error messages.
     * @param array $errors
     * @return $this
     */
    final public function setErrors(array $errors): self
    {
        $data = (array) $this->getData();
        $this->setData(Arr::set($data, 'validation_errors', $errors));

        return $this;
    }

    /**
     * Set validation errors.
     * @param ValidationException $exception
     * @return $this
     * @throws Throwable
     */
    final public function setValidationExceptionErrors(ValidationException $exception): static
    {
        $this->setApiCode(ApiCode::ERROR);
        $this->setErrors($exception->errors());

        return $this;
    }
}
