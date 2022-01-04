<?php

namespace Domain\News;

use Domain\Base\BaseListValue;

class NewsList extends BaseListValue
{
    public function filteredPublic(): NewsList
    {
        return new NewsList(array_filter($this->array, function ($news) {
            return $news->isPublic();
        }));
    }

    public function take(int $count)
    {
        return new self(array_slice($this->array, 0, $count));
    }
}
