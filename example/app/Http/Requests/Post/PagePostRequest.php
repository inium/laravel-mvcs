<?php

namespace App\Http\Requests\Post;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;

class PagePostRequest extends MvcsFormRequest
{
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
            "page" => "numeric|min:1",
            "rows" => "numeric|min:1",
            "query" => "sometimes|string|nullable",
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function defaults(): ?array
    {
        return [
            "page" => 1,
            "rows" => 20,
            "query" => null,
            "notice" => false,
        ];
    }
}
