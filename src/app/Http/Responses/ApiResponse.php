<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse extends JsonResponse
{
    /**
     * Constructor.
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return void
     */
    public function __construct(array $data = [], array $headers = [], int $options = 0)
    {
        $this->encodingOptions = $options;

        parent::__construct([
            'code' => ApiCode::SUCCESS,
            'data' => $data,
            'validation_errors' => [],
        ], Response::HTTP_OK, $headers);
    }

    final public function fail(array $errors = []): static
    {
        $this->setApiCode(ApiCode::ERROR);
        $this->setErrors($errors);

        return $this;
    }

    final public function setApiCode(int $code): self
    {
        if (in_array($code, array_values(ApiCode::all()), true)) {
            $data = (array) $this->getData();
            $this->setData(Arr::set($data, 'code', $code));
        }

        return $this;
    }

    final public function setErrors(array $errors): self
    {
        $data = (array) $this->getData();
        $this->setData(Arr::set($data, 'validation_errors', $errors));

        return $this;
    }

    /**
     * Set validation errors
     * @param ValidationException $exception
     * @return $this
     */
    final public function setErrorsFromValidationException(ValidationException $exception): static
    {
        $this->setApiCode(ApiCode::ERROR);
        $this->setErrors($exception->errors());

        return $this;
    }
}
