<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\DataTransfer\News\NewsPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\News\Content;
use Domain\News\News;
use Domain\News\NewsId;
use Domain\News\Status;
use Domain\News\Title;

interface NewsServiceInterface
{
    public function getNews(NewsId $id): News;
    public function getNewsList(Paginate $paginate): NewsPaginator;
    public function createNews(Title $title, Content $content, Status $status): News;
    public function updateNews(
        NewsId $id,
        Title $title,
        Content $content,
        Status $status,
    ): News;
    public function deleteNews(NewsId $id): bool;
}
