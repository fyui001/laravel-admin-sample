<?php

declare(strict_types=1);

namespace Domain\News;

use Domain\Base\BaseListValue;

class NewsList extends BaseListValue
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }
}
