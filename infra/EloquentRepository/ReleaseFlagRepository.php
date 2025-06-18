<?php

declare(strict_types=1);


namespace Infra\EloquentRepository;

use Domain\Exception\NotFoundException;
use Domain\ReleaseFlag\ReleaseFlag;
use Domain\ReleaseFlag\ReleaseFlagList;
use Domain\ReleaseFlag\ReleaseFlagName;
use Domain\ReleaseFlag\ReleaseFlagRepository as ReleaseFlagRepositoryInterface;
use Infra\EloquentModels\ReleaseFlag as ReleaseFlagModel;


class ReleaseFlagRepository implements ReleaseFlagRepositoryInterface
{
    public function get(ReleaseFlagName $releaseFlagName): ReleaseFlag
    {
        /** @var ReleaseFlagModel $model */
        $model = ReleaseFlagModel::where(['name' => $releaseFlagName->getValue()->getRawValue()])
            ->first();

        if (is_null($model)) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getOnlyDefinedList(): ReleaseFlagList
    {
        $collection = ReleaseFlagModel::whereIn('name', ReleaseFlagName::getValueList()->toArray())->get();

        return new ReleaseFlagList($collection->map(
            fn(ReleaseFlagModel $model) => $model->toDomain()
        )->toArray());
    }

    public function getOnlyEnabledList(): ReleaseFlagList
    {
        $collection = ReleaseFlagModel::where(['is_enabled' => true])->get();

        return new ReleaseFlagList($collection->map(
            fn(ReleaseFlagModel $model) => $model->toDomain()
        )->toArray());
    }

    public function upsert(ReleaseFlag $releaseFlag): void
    {
        $model = ReleaseFlagModel::where(['name' => $releaseFlag->getKeyName()->getValue()])->first();

        if (is_null($model)) {
            $model = new ReleaseFlagModel();
        }

        $model->name = $releaseFlag->getKeyName()->getValue()->getRawValue();

        /* @phpstan-ignore-next-line  */
        $model->is_enabled = $releaseFlag->isEnabled();

        $model->save();
    }
}
