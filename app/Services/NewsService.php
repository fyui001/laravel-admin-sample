<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\News\NewsPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\News\Content;
use Domain\News\News;
use Domain\News\NewsDomainService;
use Domain\News\NewsId;
use Domain\News\Status;
use Domain\News\Title;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsService
{
    private NewsDomainService $newsDomainService;

    public function __construct(NewsDomainService $newsDomainService)
    {
        $this->newsDomainService = $newsDomainService;
    }

    public function getNews(NewsId $id): News
    {
        return $this->newsDomainService->get($id);
    }

    /**
     * Get all news.
     *
     * @return LengthAwarePaginator
     */
    public function getNewsList(Paginate $paginate): NewsPaginator
    {
        $newsList = $this->newsDomainService->getPaginate($paginate);

        return new NewsPaginator(
            $newsList,
            $this->newsDomainService->getCount(),
            $paginate->getPerPage(),
        );
    }

    /**
     * Create news.
     *
     * @param Title $title
     * @param Content $content
     * @param Status $status
     * @return News
     */
    public function createNews(Title $title, Content $content, Status $status): News
    {
        return $this->newsDomainService->create(
            $title,
            $content,
            $status,
        );
    }

    /**
     * Update the news.
     *
     * @param NewsId $id
     * @param Title $title
     * @param Content $content
     * @param Status $status
     * @return News
     */
    public function updateNews(
        NewsId $id,
        Title $title,
        Content $content,
        Status $status,
    ): News {
        return $this->newsDomainService->update(
            $id,
            $title,
            $content,
            $status,
        );
    }

    /**
     * Delete the news.
     *
     * @param NewsId $id
     * @return bool
     */
    public function deleteNews(NewsId $id): bool
    {
        return $this->newsDomainService->delete($id);
    }
}
