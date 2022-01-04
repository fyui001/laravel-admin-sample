<?php

declare(strict_types=1);

namespace Domain\News;

use Illuminate\Pagination\LengthAwarePaginator;

class NewsDomainService
{
    private NewsRepository $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(NewsId $id): News
    {
        return $this->repository->get($id);
    }

    public function getPaginate(): LengthAwarePaginator
    {
        return $this->repository->getPaginate();
    }

    public function create(Title $title, Content $content, Status $status): News
    {
        return $this->repository->create($title, $content, $status);
    }

    public function update(NewsId $id, Title $title, Content $content, Status $status)
    {
        $this->repository->update($id, $title, $content, $status);
    }

    public function delete(NewsId $id)
    {
        $this->repository->delete($id);
    }
}
