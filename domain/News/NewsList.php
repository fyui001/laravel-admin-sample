<?php

declare(strict_types=1);

namespace Domain\News;

use Domain\Common\ListValue;

class NewsList extends ListValue
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }
}
