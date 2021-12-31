<?php
declare(strict_types=1);

namespace Infra\EloquentModel\Base;

use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Contracts\Auditable;

abstract class BasePivotModel extends Pivot implements Auditable
{
    use AuditableTrait;
}
