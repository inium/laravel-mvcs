<?php

namespace App\Modules\Post\Dto;

class CreatePostDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param bool $notice      공지사항 여부
     * @param string $subject   게시글 제목
     * @param string $content   게시글 본문
     */
    public function __construct(
        public readonly bool $notice,
        public readonly string $subject,
        public readonly string $content
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
