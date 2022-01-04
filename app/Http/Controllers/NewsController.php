<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Services\Interfaces\NewsServiceInterface;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use Domain\News\News;
use Domain\News\NewsId;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     * @return View
     */
    public function index(): View
    {
        $news = $this->newsService->getNewsList();
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
        if (!$this->newsService->createNews($request)) {
            return  redirect(route('news.index'))->with(['error' => 'ニュースを作成できませんでした']);
        }

        return redirect(route('news.index'))->with(['success' => 'ニュースを作成しました']);
    }

    /**
     * Form to update the news.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View {
        $news = $this->newsService->getNews(
            new NewsId((int)$id)
        );
        return view('news.edit', compact('news'));

    }

    /**
     * Update the news.
     *
     * @param string $id
     * @param UpdateNewsRequest $request
     * @return RedirectResponse
     */
    public function update(string $id, UpdateNewsRequest $request): RedirectResponse
    {
        $this->newsService->updateNews(
            new NewsId((int)$id),
            $request
        );
        return redirect(route('news.index'))->with(['success' => 'ニュースを変更しました']);
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
        return redirect(route('news.index'))->with(['success' => 'ニュースを削除しました']);
    }

}
