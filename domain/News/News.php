<?php

declare(strict_types=1);

namespace Domain\News;

class News
{
    private NewsId $id;
    private Title $title;
    private Content $content;
    private Status $status;

    public function __construct(NewsId $id, Title $title, Content $content, Status $status)
    {
        $this->id = $id;
        $this->status = $status;
        $this->title = $title;
        $this->content = $content;
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
