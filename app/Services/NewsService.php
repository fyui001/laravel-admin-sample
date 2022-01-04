<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as BaseService;
use App\Services\Interfaces\NewsServiceInterface;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use Domain\News\News;
use Domain\News\NewsDomainService;
use Domain\News\NewsId;
use Domain\News\Title;
use Domain\News\Content;
use Domain\News\Status;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsService extends BaseService implements NewsServiceInterface
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
    public function getNewsList(): LengthAwarePaginator
    {
        return $this->newsDomainService->getPaginate();
    }

    /**
     * Create news.
     *
     * @param CreateNewsRequest $request
     * @return void
     */
    public function createNews(CreateNewsRequest $request): News
    {
        return $this->newsDomainService->create(
            new Title($request->input('title')),
            new Content($request->input('content')),
            new Status($request->input('status'))
        );
    }

    /**
     * Update the news.
     *
     * @param NewsId $id
     * @param UpdateNewsRequest $request
     */
    public function updateNews(NewsId $id, UpdateNewsRequest $request): void
    {
        $this->newsDomainService->update(
            $id,
            new Title($request->input('title')),
            new Content($request->input('content')),
            new Status((int)$request->input('status'))
        );
    }

    /**
     * Delete the news.
     *
     * @param NewsId $id
     */
    public function deleteNews(NewsId $id): void
    {
        $this->newsDomainService->delete($id);
    }
}
