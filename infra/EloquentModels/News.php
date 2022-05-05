<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Infra\EloquentModels\Model as AppModel;
use Domain\News\News as NewsDomain;
use Domain\News\NewsId;
use Domain\News\Title;
use Domain\News\Content;
use Domain\News\Status;

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
            Status::tryFrom((int)$this->status),
        );
    }
}
