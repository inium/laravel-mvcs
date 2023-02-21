<?php

namespace App\Modules\Board\Dto;

class BoardDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param integer $id               게시글 id
     * @param string $name              영문 게시판 이름
     * @param string $nameKo            한글 게시판 이름
     * @param string $description       게시판 설명
     * @param string $createdAt         게시판 생성일
     * @param string $updatedAt         게시판 정보 갱신일
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $nameKo,
        public readonly string $description,
        public readonly string $createdAt,
        public readonly string $updatedAt
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
