<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseEnum;

class JoinOperator extends BaseEnum
{
    const AND = 'and';
    const OR = 'or';

    public function displayName(): string
    {
        switch ($this->rawValue()) {
            case self:: AND:
                return "AND";
            case self:: OR:
                return "OR";
        }
    }

    public function isAnd(): bool
    {
        return $this->is(self::AND);
    }
}
