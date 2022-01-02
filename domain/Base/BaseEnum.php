<?php
declare(strict_types=1);

namespace Domain\Base;

use Domain\Exception\InvalidArgumentException;
use Lib\Enum\BaseEnum as LibEnum;

abstract class BaseEnum extends LibEnum
{
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
