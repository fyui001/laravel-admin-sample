<?php
declare(strict_types=1);

namespace Infra\EloquentModel\Base;

use Illuminate\Foundation\Auth\User;
use OwenIt\Auditing\Contracts\Auditable;

abstract class BaseAuthenticatable extends User implements Auditable
{
    use AuditableTrait;
}
