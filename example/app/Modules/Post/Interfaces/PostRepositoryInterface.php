<?php

namespace App\Modules\Post\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Get # of rows
     *
     * @param string $boardName Board name
     * @return int  # of rows
     */
    public function count(string $boardName): int;

    /**
     * Get all rows
     *
     * @param string $boardName Board name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(string $boardName): Collection;

    /**
     * Paginate contents
     *
     * @param string $boardName Board name
     * @param bool $notice      Notice or not
     * @param int $page         Page number
     * @param int $rows         # of rows
     * @param bool $desc        Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function paginate(
        string $boardName,
        bool $notice,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find contents
     *
     * @param string $boardName Board name
     * @param bool $notice      Notice or not
     * @param string $query     Query string
     * @param int $page         Page number
     * @param int $rows         # of rows
     * @param bool $notice      Notice or not
     * @param bool $desc        Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function find(
        string $boardName,
        bool $notice,
        string $query,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find a content
     *
     * @param string $boardName Board name
     * @param int $id
     * @return array
     */
    public function findOne(string $boardName, int $id): array;

    /**
     * Create a content
     *
     * @param array $data   Contents to be created (consist of key => value)
     * @param int $boardId  Board ID
     * @param int $userId   User ID
     * @return array
     */
    public function create(array $data, int $boardId, int $userId): array;

    /**
     * Update a content
     *
     * @param array $data   Contents to be updated (consist of key => value)
     * @param int $boardId  Board ID
     * @param int $userId   User ID
     * @param int $id
     * @return int # of affected rows
     */
    public function update(
        array $data,
        int $boardId,
        int $userId,
        int $id
    ): int;

    /**
     * Delete a content
     *
     * @param string $boardName  Board name
     * @param int $id
     * @return int  1: success, 0: fail
     */
    public function delete(string $boardName, int $id): int;

    /**
     * Increment view count
     *
     * @param string $boardName Board name
     * @param int $id
     * @return int # of affected rows
     */
    public function incrementViewCount(string $boardName, int $id): int;
}
