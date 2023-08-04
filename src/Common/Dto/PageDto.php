<?php

namespace Inium\Mvcs\Common\Dto;

use Inium\Mvcs\Common\Dto\PageMetaDto;

class PageDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param array $data           Page items
     * @param PageMetaDto $meta     Page Meta
     */
    public function __construct(
        public readonly array $data,
        public PageMetaDto $meta
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
