<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Infra\EloquentModels\BaseModel as AppModel;
use Domain\News\News as NewsDomain;
use Domain\News\NewsId;
use Domain\News\Title;
use Domain\News\Content;
use Domain\News\Status;

/**
 * Infra\EloquentModels\News
 *
 * @property int $id
 * @property string $title タイトル
 * @property string $content 本分
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class News extends AppModel
{
    protected $table = 'news';

    public $guarded = [
        'id',
    ];

    public function toDomain()
    {
        return new NewsDomain(
            new NewsId($this->id),
            new Title($this->title),
            new Content($this->content),
            Status::tryFrom($this->status),
        );
    }
}
