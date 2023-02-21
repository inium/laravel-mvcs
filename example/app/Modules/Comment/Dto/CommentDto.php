<?php

namespace App\Modules\Comment\Dto;

class CommentDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param integer $id           댓글 ID
     * @param string $content       본문
     * @param array $board          게시판 정보
     * @param array $post           게시글 정보
     * @param array $user           사용자 정보
     * @param ?array $parent        부모 댓글 정보
     * @param int $childrenCount    자식 댓글 개수
     * @param string $createdAt     댓글 생성일
     * @param string $updatedAt     댓글 수정일
     */
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly array $board,
        public readonly array $post,
        public readonly array $user,
        public readonly ?array $parent,
        public readonly int $childrenCount,
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
