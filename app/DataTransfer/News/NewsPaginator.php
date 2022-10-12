<?php

declare(strict_types=1);

namespace App\DataTransfer\News;

use Domain\Common\Paginator\PerPage;
use Domain\News\NewCount;
use Domain\News\NewsList;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsPaginator extends LengthAwarePaginator
{
    public function __construct(
        NewsList $newsList,
        NewCount $newCount,
        PerPage $perPage
    ) {
        parent::__construct(
            $newsList,
            $newCount->getRawValue(),
            $perPage->getRawValue(),
        );
    }
}
