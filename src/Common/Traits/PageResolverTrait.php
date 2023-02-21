<?php

namespace Inium\Mvcs\Common\Traits;

use Illuminate\Pagination\Paginator;

trait PageResolverTrait
{
    /**
     * Explicit paginator page number
     *
     * @param integer $pageNum
     * @return void
     */
    protected function setPageNum(int $pageNum): void
    {
        Paginator::currentPageResolver(function () use ($pageNum) {
            return $pageNum;
        });
    }
}
