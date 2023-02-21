<?php

namespace App\Http\Requests\Comment;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;
use App\Modules\Comment\Dto\CreateCommentDto;

class CreateCommentRequest extends MvcsFormRequest
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
            "content" => "required|string",
            "parentCommentId" => "sometimes|nullable|numeric|min:1",
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function defaults(): ?array
    {
        return [
            "parentCommentId" => null,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function dtoClassName(): ?string
    {
        return CreateCommentDto::class;
    }
}
