<?php

namespace App\Modules\Board\Interfaces;

use App\Modules\Board\Dto\BoardDto;
use App\Modules\Board\Dto\PageBoardDto;
use App\Modules\Board\Dto\CreateBoardDto;
use App\Modules\Board\Dto\UpdateBoardDto;

interface BoardServiceInterface
{
    /**
     * Paginate contents
     *
     * @param int $page     Page number
     * @param int $rows     # of rows per page
     * @return PageBoardDto
     */
    public function paginate(int $page, int $rows): PageBoardDto;

    /**
     * Search contents
     *
     * @param int $page     Page number
     * @param int $rows     # of rows per page
     * @param string $query Search text
     * @return PageBoardDto
     */
    public function find(string $query, int $page, int $rows): PageBoardDto;

    /**
     * Find a content by name
     *
     * @param string $boardName   Board name
     * @return BoardDto
     */
    public function findOne(string $boardName): BoardDto;

    /**
     * Create a content
     *
     * @param CreateBoardDto $dto Dto
     * @return BoardDto
     */
    public function create(CreateBoardDto $dto): BoardDto;

    /**
     * Update a content
     *
     * @param UpdateBoardDto $dto   Dto
     * @param string $boardName     Board name
     * @return int  # of affected rows
     */
    public function update(UpdateBoardDto $dto, string $boardName): int;

    /**
     * Delete a content by name
     *
     * @param string $boardName   Board name
     * @return int  # of deleted rows
     */
    public function delete(string $boardName): int;
}
