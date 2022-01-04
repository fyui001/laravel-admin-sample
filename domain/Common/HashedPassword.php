<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseStringValue;
use Illuminate\Contracts\Hashing\Hasher;

class HashedPassword extends BaseStringValue
{
    public function check(Hasher $hasher, RawPassword $rawPassword): bool
    {
        return $hasher->check($rawPassword->rawValue(), $this->rawValue());
    }
}
