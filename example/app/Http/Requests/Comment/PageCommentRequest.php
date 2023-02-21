<?php

namespace App\Http\Requests\Comment;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;

class PageCommentRequest extends MvcsFormRequest
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
            "parent" => "sometimes|numeric|nullable|min:1",
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
            "rows" => 1,
            "parent" => null,
            "query" => null,
        ];
    }
}
