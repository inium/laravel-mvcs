<?php

namespace App\Modules\Board\Dto;

class PageBoardDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param array $items          Page items
     * @param integer $total        # of total items
     * @param integer $currentPage  # of current page
     * @param integer $lastPage     # of last page
     * @param integer $perPage      # of items per page
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $currentPage,
        public readonly int $lastPage,
        public readonly int $perPage
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
