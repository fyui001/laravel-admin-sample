<?php

declare(strict_types=1);

namespace Domain\Common;

interface UrlInterface
{
    public static function makeDummy(): self;
    public function getUrlEncoded(): string;
}
