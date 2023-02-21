<?php

namespace App\Modules\Post\Dto;

class PostDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param integer $id               게시글 ID
     * @param bool $notice              공지사항
     * @param string $subject           제목
     * @param string $content           본문
     * @param int $viewCount            조회수
     * @param int $commentCount         댓글 수
     * @param int|null $parentCommentId 부모 댓글 ID
     * @param array $board              게시판 정보
     * @param array $user               사용자 정보
     * @param string $createdAt         게시글 생성일
     * @param string $updatedAt         게시글 수정일
     */
    public function __construct(
        public readonly int $id,
        public readonly bool $notice,
        public readonly string $subject,
        public readonly string $content,
        public readonly int $viewCount,
        public readonly ?int $parentCommentId,
        public readonly array $board,
        public readonly array $user,
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
