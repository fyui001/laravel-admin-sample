<?php
declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseStringValue;
use Illuminate\Contracts\Hashing\Hasher;

class RawPassword extends BaseStringValue
{
    public function hash(Hasher $hasher)
    {
        return new HashedPassword($hasher->make($this->rawValue()));
    }

    public static function makeRandomPassword()
    {
        return new self(self::makeRandomString(16));
    }
}
