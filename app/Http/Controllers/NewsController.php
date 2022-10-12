<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Http\Requests\Admin\AdminRequest;
use App\Services\Interfaces\NewsServiceInterface;
use App\Http\Requests\Admin\News\CreateNewsRequest;
use App\Http\Requests\Admin\News\UpdateNewsRequest;
use Domain\Common\Paginator\Paginate;
use Domain\News\NewsId;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Infra\EloquentModels\News;

class NewsController extends AppController
{
    protected NewsServiceInterface $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        parent::__construct();
        $this->newsService = $newsService;
    }

    /**
     * Index of news.
     *
     * @param AdminRequest $request
     * @return View
     */
    public function index(AdminRequest $request): View
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20);

        $paginate = Paginate::make((int)$page, (int)$perPage);

        $news = $this->newsService->getNewsList($paginate);

        return view('news.index', compact('news'));
    }

    /**
     * Form to create news.
     *
     * @return View
     */
    public function create(): View
    {
        return view('news.create');
    }

    /**
     * Create news.
     *
     * @param CreateNewsRequest $request
     * @return RedirectResponse
     */
    public function store(CreateNewsRequest $request): RedirectResponse
    {
        $result = $this->newsService->createNews(
            $request->getTitle(),
            $request->getContent(),
            $request->getStatus(),
        );
        if (empty($result)) {
            return  redirect(route('admin.news.index'))->with(['error' => 'ニュースを作成できませんでした']);
        }

        return redirect(route('admin.news.index'))->with(['success' => 'ニュースを作成しました']);
    }

    /**
     * Form to update the news.
     *
     * @param News $news
     * @return View
     */
    public function edit(News $news): View
    {
        $news = $this->newsService->getNews(
            $news->toDomain()->id()
        );
        return view('news.edit', compact('news'));
    }

    /**
     * Update the news.
     *
     * @param News $news
     * @param UpdateNewsRequest $request
     * @return RedirectResponse
     */
    public function update(News $news, UpdateNewsRequest $request): RedirectResponse
    {
        $this->newsService->updateNews(
            $news->toDomain()->id(),
            $request->getTitle(),
            $request->getContent(),
            $request->getStatus(),
        );

        return redirect(route('admin.news.index'))->with(['success' => 'ニュースを変更しました']);
    }

    /**
     * Delete the news.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->newsService->deleteNews(
            new NewsId((int)$id)
        );
        return redirect(route('admin.news.index'))->with(['success' => 'ニュースを削除しました']);
    }
}
