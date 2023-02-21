<?php

namespace App\Http\Requests\Board;

use Inium\Mvcs\Common\Requests\MvcsFormRequest;
use App\Modules\Board\Dto\CreateBoardDto;

class CreateBoardRequest extends MvcsFormRequest
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
            "name" => "required|string|unique:App\Models\Board,name",
            "nameKo" => "required|string|unique:App\Models\Board,name_ko",
            "description" => "required|string",
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            "name" => "영문 이름",
            "nameKo" => "한글 이름",
            "description" => "게시판 설명",
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
        return CreateBoardDto::class;
    }
}
