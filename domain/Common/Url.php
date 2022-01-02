<?php

declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseStringValue;

class Url extends BaseStringValue implements UrlInterface
{
    public static function makeDummy(): self
    {
        return new static('https://example.com');
    }

    public function getUrlEncoded(): string
    {
        return urlencode($this->rawValue());
    }
}
