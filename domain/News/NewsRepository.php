<?php

declare(strict_types=1);

namespace Domain\News;


use Domain\Common\Paginator\Paginate;

interface NewsRepository
{
    public function get(NewsId $id): News;
    public function getPaginate(Paginate $paginate): NewsList;
    public function getCount(): NewCount;
    public function create(Title $title, Content $content, Status $status): News;
    public function update(NewsId $id, Title $title, Content $content, Status $status): News;
    public function delete(NewsId $id): bool;
}
