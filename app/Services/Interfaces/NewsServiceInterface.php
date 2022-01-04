<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use Domain\News\News;
use Domain\News\NewsId;
use Illuminate\Pagination\LengthAwarePaginator;

interface NewsServiceInterface
{
    public function getNews(NewsId $id): News;
    public function getNewsList(): LengthAwarePaginator;
    public function createNews(CreateNewsRequest $request): News;
    public function updateNews(NewsId $id, UpdateNewsRequest $request): void;
    public function deleteNews(NewsId $id): void;
}
