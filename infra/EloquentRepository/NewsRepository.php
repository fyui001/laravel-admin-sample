<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\News\NewsRepository as NewsRepositoryInterface;
use Domain\News\News as NewsDomain;
use Domain\News\NewsId;
use Domain\News\Title;
use Domain\News\Content;
use Domain\News\Status;
use Domain\Exception\NotFoundException;
use Infra\EloquentModels\News as NewsModel;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsRepository implements NewsRepositoryInterface
{
    public function get(NewsId $id): NewsDomain
    {
        $model = NewsModel::where(['id' => $id])
            ->first();
        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getPaginate(): LengthAwarePaginator
    {
        return NewsModel::paginate(15);
    }

    public function create(Title $title, Content $content, Status $status): NewsDomain
    {
        $model = new NewsModel();
        $model->title = $title->rawValue();
        $model->content = $content->rawValue();
        $model->status = $status->rawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(NewsId $id, Title $title, Content $content, Status $status)
    {
        $model = NewsModel::where(['id' => $id])->first();
        $model->title = $title->rawValue();
        $model->content = $content->rawValue();
        $model->status = $status->rawValue();
        $model->save();
    }

    public function delete(NewsId $id)
    {
        $model = NewsModel::where(['id' => $id])->first();
        if (!$model) {
            throw new NotFoundException();
        }
        $model->delete();
    }
}
