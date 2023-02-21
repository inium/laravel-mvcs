<?php

namespace Inium\Multier\Common\Base\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
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
     * Paginate
     *
     * @param integer $page     Page number
     * @param integer $rows     # of rows
     * @param boolean $desc     Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function paginate(
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Search contents by query
     *
     * @param string $query     query string
     * @param integer $page     Page number
     * @param integer $rows     # of rows
     * @param boolean $desc     Order by (true: DESC, false: ASC)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator;
     */
    public function find(
        string $query,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator;

    /**
     * Find by id
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findById(int $id): Model;

    /**
     * Create
     *
     * @param array $data   Contents to be created (consist of key => value)
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model;

    /**
     * Update
     *
     * @param array $data   Contents to be updated (consist of key => value)
     * @param integer $id
     * @return integer      # of affected rows
     */
    public function update(array $data, int $id): int;

    /**
     * Delete by id
     *
     * @param integer $id
     * @return integer      1: success, 0: fail
     */
    public function deleteById(int $id): int;
}
