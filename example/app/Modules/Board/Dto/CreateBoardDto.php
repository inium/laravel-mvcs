<?php

namespace App\Modules\Board\Dto;

class CreateBoardDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param string $name              영문 게시판 이름
     * @param string $nameKo            한글 게시판 이름
     * @param string $description       게시판 설명
     */
    public function __construct(
        public readonly string $name,
        public readonly string $nameKo,
        public readonly string $description
    ) {
    }

    /**
     * Serialize member variables to an array
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
