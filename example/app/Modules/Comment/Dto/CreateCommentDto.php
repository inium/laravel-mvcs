<?php

namespace App\Modules\Comment\Dto;

class CreateCommentDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param string $content           본문
     * @param int|null $parentCommentId 부모 댓글 ID
     */
    public function __construct(
        public readonly string $content,
        public readonly int|null $parentCommentId = null
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
