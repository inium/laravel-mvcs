<?php

namespace App\Modules\Comment\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CommentRepositoryInterface
{
    /**
     * Get # of rows
     *
     * @return integer  # of rows
     */
    public function count(): int;

    /**
     * Get all rows
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection;

    /**
     * Paginate contents
     *
     * @param string $boardName         Board name
     * @param int $postId               Post Id
     * @param int $page                 Page number
     * @param int $rows                 # of rows
     * @param int|null $parentCommentId 부모 댓글 ID
     * @param bool $desc                Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function paginate(
        string $boardName,
        int $postId,
        int $page,
        int $rows,
        ?int $parentCommentId = null,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find contents
     *
     * @param string $boardName         Board name
     * @param int $postId               Post Id
     * @param string $query             Query string
     * @param int $page                 Page number
     * @param int $rows                 # of rows
     * @param int|null $parentCommentId 부모 댓글 ID
     * @param bool $desc                Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function find(
        string $boardName,
        int $postId,
        string $query,
        int $page,
        int $rows,
        ?int $parentCommentId = null,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find a content
     *
     * @param string $boardName Board name
     * @param int $postId       Post Id
     * @param int $id
     * @return array
     */
    public function findOne(string $boardName, int $postId, int $id): array;

    /**
     * Create a content
     *
     * @param array $data   Contents to be created (key => value)
     * @param int $boardId  Board Id
     * @param int $postId   Post Id
     * @param int $userId   User Id
     * @param int|null $parentCommentId Parent comment Id
     * @return array
     */
    public function create(
        array $data,
        int $boardId,
        int $postId,
        int $userId,
        int|null $parentCommentId = null
    ): array;

    /**
     * Update a content
     *
     * @param array $data       Contents to be updated (key => value)
     * @param int $boardId      Board Id
     * @param int $postId       Post Id
     * @param int $userId       User Id
     * @param int $id           Comment Id
     * @param int|null $parentCommentId Parent comment Id
     * @return int  # of affected rows
     */
    public function update(
        array $data,
        int $boardId,
        int $postId,
        int $userId,
        int $id,
        int|null $parentCommentId = null
    ): int;

    /**
     * Delete a content
     *
     * @param string $boardName         Board name
     * @param int $postId               Post Id
     * @param int $id
     * @return int  1: success, 0: fail
     */
    public function delete(string $boardName, int $postId, int $id): int;
}
