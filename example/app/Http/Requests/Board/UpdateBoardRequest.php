<?php

namespace App\Http\Requests\Board;

use Illuminate\Validation\Rule;
use Inium\Mvcs\Common\Requests\MvcsFormRequest;
use App\Modules\Board\Dto\UpdateBoardDto;
use App\Models\Board;

class UpdateBoardRequest extends MvcsFormRequest
{
    /**
     * Board tableName
     *
     * @var string
     */
    private string $tableName;

    /**
     * constructor
     *
     * @param Board $model
     */
    public function __construct(Board $model)
    {
        parent::__construct();
        $this->tableName = $model->getTable();
    }

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
            "name" => [
                "required",
                "string",
                Rule::unique($this->tableName, "name")->ignore(
                    $this->boardName,
                    "name"
                ),
            ],
            "nameKo" => [
                "required",
                "string",
                Rule::unique($this->tableName, "name_ko")->ignore(
                    $this->boardName,
                    "name"
                ),
            ],
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
        return UpdateBoardDto::class;
    }
}
