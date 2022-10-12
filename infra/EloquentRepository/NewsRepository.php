<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Common\OrderKey;
use Domain\News\NewCount;
use Domain\News\News;
use Domain\News\NewsList;
use Domain\News\NewsRepository as NewsRepositoryInterface;
use Domain\News\News as NewsDomain;
use Domain\News\NewsId;
use Domain\News\Title;
use Domain\News\Content;
use Domain\News\Status;
use Domain\Exception\NotFoundException;
use Infra\EloquentModels\News as NewsModel;

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

    public function getPaginate($paginate): NewsList
    {
        $builder = NewsModel::query()
            ->orderBy('id', OrderKey::DESC->getValue()->getRawValue())
            ->limit($paginate->getLimit()->getRawValue())
            ->offset($paginate->offset()->getRawValue());

        $collection = $builder->get();

        return new NewsList(
            $collection->map(function (NewsModel $model) {
                return $model->toDomain();
            })->toArray()
        );
    }

    public function getCount(): NewCount
    {
        $query = NewsModel::query();

        return new NewCount($query->count());
    }

    public function create(Title $title, Content $content, Status $status): NewsDomain
    {
        $model = new NewsModel();
        $model->title = $title->getRawValue();
        $model->content = $content->getRawValue();
        $model->status = $status->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(NewsId $id, Title $title, Content $content, Status $status): NewsDomain
    {
        $model = NewsModel::where(['id' => $id])->first();
        $model->title = $title->getRawValue();
        $model->content = $content->getRawValue();
        $model->status = $status->getValue()->getRawValue();
        $model->save();

        return $model->toDomain();
    }

    public function delete(NewsId $id): bool
    {
        $model = NewsModel::where(['id' => $id])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->delete();
    }
}
