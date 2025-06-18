<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\ReleaseFlag\IsEnabled;
use Domain\ReleaseFlag\ReleaseFlag as ReleaseFlagDomain;
use Domain\ReleaseFlag\ReleaseFlagName;


/**
 * Infra\EloquentModels\ReleaseFlag
 *
 * @property string $name
 * @property bool $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseFlag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReleaseFlag extends BaseModel
{
    protected $table = 'release_flags';
    protected $primaryKey = 'name';
    protected $keyType = 'string';

    protected $fillable = ['name', 'is_enabled'];

    public $incrementing = false;

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function toDomain(): ReleaseFlagDomain
    {
        return new ReleaseFlagDomain(
            ReleaseFlagName::tryFrom((string)$this->name),
            new IsEnabled((bool)$this->is_enabled),
        );
    }
}
