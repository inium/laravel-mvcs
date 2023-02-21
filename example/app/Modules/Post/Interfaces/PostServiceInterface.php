<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\Dto\PostDto;
use App\Modules\Post\Dto\PagePostDto;
use App\Modules\Post\Dto\CreatePostDto;
use App\Modules\Post\Dto\UpdatePostDto;

interface PostServiceInterface
{
    /**
     * Paginate contents
     *
     * @param string $boardName Board name
     * @param bool $notice      Notice or not
     * @param int $page         Page number
     * @param int $rows         # of rows per page
     * @return PagePostDto
     */
    public function paginate(
        string $boardName,
        bool $notice,
        int $page,
        int $rows
    ): PagePostDto;

    /**
     * Find contents
     *
     * @param string $boardName Board name
     * @param bool $notice      Notice or not
     * @param int $page         Page number
     * @param int $rows         # of rows per page
     * @param string $query     Query text
     * @return PagePostDto
     */
    public function find(
        string $boardName,
        bool $notice,
        string $query,
        int $page,
        int $rows
    ): PagePostDto;

    /**
     * Find a content
     *
     * @param string $boardName Board name
     * @param int $id           Content id
     * @return PostDto
     */
    public function findOne(string $boardName, int $id): PostDto;

    /**
     * Create a content
     *
     * @param CreatePostDto $dto    Dto
     * @param string $boardName     Board name
     * @return PostDto
     */
    public function create(CreatePostDto $dto, string $boardName): PostDto;

    /**
     * Update a content
     *
     * @param UpdatePostDto $dto    Dto
     * @param string $boardName     Board name
     * @param int $id               Content id
     * @return int  # of affected rows
     */
    public function update(UpdatePostDto $dto, string $boardName, int $id): int;

    /**
     * Delete a content
     *
     * @param string $boardName Board name
     * @param int $id           Content id
     * @return int  # of deleted rows
     */
    public function delete(string $boardName, int $id): int;
}
