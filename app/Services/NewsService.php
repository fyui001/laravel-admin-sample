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
            $request->getTitle(),
            $request->getContent(),
            $request->getStatus()
        );
    }

    /**
     * Update the news.
     *
     * @param NewsId $id
     * @param UpdateNewsRequest $request
     */
    public function updateNews(NewsId $id, UpdateNewsRequest $request): News
    {
        return $this->newsDomainService->update(
            $id,
            $request->getTitle(),
            $request->getContent(),
            $request->getStatus()
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
