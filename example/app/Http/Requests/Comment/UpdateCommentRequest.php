<?php

namespace App\Http\Requests\Comment;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;
use App\Modules\Comment\Dto\UpdateCommentDto;

class UpdateCommentRequest extends MvcsFormRequest
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
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function defaults(): ?array
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function dtoClassName(): ?string
    {
        return UpdateCommentDto::class;
    }
}
