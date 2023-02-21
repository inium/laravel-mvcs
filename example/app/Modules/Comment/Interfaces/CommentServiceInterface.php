<?php

namespace App\Modules\Comment\Interfaces;

use App\Modules\Comment\Dto\CommentDto;
use App\Modules\Comment\Dto\PageCommentDto;
use App\Modules\Comment\Dto\CreateCommentDto;
use App\Modules\Comment\Dto\UpdateCommentDto;

interface CommentServiceInterface
{
    /**
     * Paginate contents
     *
     * @param string $boardName Board name
     * @param int $postId       Post Id
     * @param int $page         Page number
     * @param int $rows         # of rows per page
     * @param int|null $parentCommentId  부모 댓글 ID
     * @return PageCommentDto
     */
    public function paginate(
        string $boardName,
        int $postId,
        int $page,
        int $rows,
        ?int $parentCommentId = null
    ): PageCommentDto;

    /**
     * Find contents
     *
     * @param string $boardName Board name
     * @param int $postId       Post Id
     * @param string $query     Query text
     * @param int $page         Page number
     * @param int $rows         # of rows per page
     * @param int|null $parentCommentId  부모 댓글 ID
     * @return PageCommentDto
     */
    public function find(
        string $boardName,
        int $postId,
        string $query,
        int $page,
        int $rows,
        ?int $parentCommentId = null
    ): PageCommentDto;

    /**
     * Find a content
     *
     * @param string $boardName Board name
     * @param int $postId       Post Id
     * @param int $id           Content id
     * @return CommentDto
     */
    public function findOne(
        string $boardName,
        int $postId,
        int $id
    ): CommentDto;

    /**
     * Create a content
     *
     * @param CreateCommentDto $dto Dto
     * @param string $boardName     Board name
     * @param int $postId           Post Id
     * @return CommentDto
     */
    public function create(
        CreateCommentDto $dto,
        string $boardName,
        int $postId
    ): CommentDto;

    /**
     * Update a content
     *
     * @param UpdateCommentDto $dto Dto
     * @param string $boardName     Board name
     * @param int $postId           Post Id
     * @param int $id               Content id
     * @return int  # of affected rows
     */
    public function update(
        UpdateCommentDto $dto,
        string $boardName,
        int $postId,
        int $id
    ): int;

    /**
     * Delete a content
     *
     * @param string $boardName Board name
     * @param int $postId       Post Id
     * @param int $id          Content id
     * @return int  # of deleted rows
     */
    public function delete(string $boardName, int $postId, int $id): int;
}
