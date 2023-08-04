<?php

namespace Inium\Mvcs\Common\Dto;

class PageMetaDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param int $total        # of total items
     * @param int $currentPage  # of current page
     * @param int $lastPage     # of last page
     * @param int $perPage      # of items per page
     */
    public function __construct(
        public readonly int $total,
        public readonly int $currentPage,
        public readonly int $lastPage,
        public readonly int $perPage
    ) {
    }

    /**
     * Convert meta data in array to each member variable
     *
     * @param array $meta
     * @return void
     */
    public static function fromArray(array $meta): PageMetaDto
    {
        return new static(
            $meta["total"],
            $meta["currentPage"],
            $meta["lastPage"],
            $meta["perPage"]
        );
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
