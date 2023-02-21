<?php

namespace App\Http\Requests\Post;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;
use App\Modules\Post\Dto\UpdatePostDto;

class UpdatePostRequest extends MvcsFormRequest
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
            "subject" => "required|string",
            "content" => "required|string",
            "notice" => "sometimes|boolean",
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function defaults(): ?array
    {
        return [
            "notice" => false,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function dtoClassName(): ?string
    {
        return UpdatePostDto::class;
    }
}
