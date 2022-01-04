<?php

declare(strict_types=1);

namespace Domain\News;

use Illuminate\Pagination\LengthAwarePaginator;

interface NewsRepository
{
    public function get(NewsId $id): News;
    public function getPaginate(): LengthAwarePaginator;
    public function create(Title $title, Content $content, Status $status): News;
    public function update(NewsId $id, Title $title, Content $content, Status $status);
    public function delete(NewsId $id);
}
