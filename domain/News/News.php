<?php

declare(strict_types=1);

namespace Domain\News;

readonly class News
{

    public function __construct(
        private NewsId $id,
        private Title $title,
        private Content $content,
        private Status $status
    ) {
    }

    public function id(): NewsId
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
