<?php

namespace App\Modules\Comment\Dto;

class UpdateCommentDto implements \JsonSerializable
{
    /**
     * Constructor
     *
     * @param string $content   본문
     */
    public function __construct(public readonly string $content)
    {
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
