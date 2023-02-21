<?php

namespace Inium\Multier\Common\Base\Dto;

class PageDto implements \JsonSerializable
{
    /**
     * Current items (Pagination Items - DTO)
     *
     * @var array
     */
    private array $items;

    /**
     * # of total items
     *
     * @var integer
     */
    private int $total;

    /**
     * # of current pages
     *
     * @var integer
     */
    private int $currentPage;

    /**
     * # of last page
     *
     * @var integer
     */
    private int $lastPage;

    /**
     * # of items per page
     *
     * @var integer
     */
    private int $perPage;

    /**
     * Constructor
     *
     * @param array $items          Current items (Pagination Items - DTO)
     * @param integer $total        # of total items
     * @param integer $currentPage  # of current pages
     * @param integer $lastPage     # of last page
     * @param integer $perPage      # of items per page
     */
    public function __construct(
        array $items,
        int $total,
        int $currentPage,
        int $lastPage,
        int $perPage
    ) {
        $this->items = $items;
        $this->total = $total;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->perPage = $perPage;
    }

    /**
     * Serialize Json
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * Get the value of items
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get the value of total
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Get the value of currentPage
     *
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Get the value of lastPage
     *
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Get the value of perPage
     *
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
