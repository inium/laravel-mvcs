<?php

namespace App\Modules\Board\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BoardRepositoryInterface
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
     * @param int $page     Page number
     * @param int $rows     # of rows
     * @param bool $desc    Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function paginate(
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find contents
     *
     * @param string $query Query string
     * @param int $page     Page number
     * @param int $rows     # of rows
     * @param bool $desc    Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function find(
        string $query,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find a content by name
     *
     * @param string $boardName Board name
     * @return array
     */
    public function findOne(string $boardName): array;

    /**
     * Create a content
     *
     * @param array $data   Contents to be created (consist of key => value)
     * @return array
     */
    public function create(array $data): array;

    /**
     * Update a content
     *
     * @param array $data       Contents to be updated (consist of key => value)
     * @param string $boardName Board name
     * @return int  # of affected rows
     */
    public function update(array $data, string $boardName): int;

    /**
     * Delete a content by name
     *
     * @param string $boardName
     * @return int  1: success, 0: fail
     */
    public function delete(string $boardName): int;
}
