<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginateRequest extends FormRequest
{
    /**
     * Max limit of the Pagination.
     */
    public const MAX_LIMIT = 100;

    /**
     * Default limit of the Pagination.
     */
    public const DEFAULT_LIMIT = 20;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "per_page" => "sometimes|int|max:" . self::MAX_LIMIT,
            "page" => "sometimes|int",
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        if (! $this->get('per_page')) {
            $this->merge([
                'per_page' => self::DEFAULT_LIMIT
            ]);
        }
    }
}
