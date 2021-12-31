<?php
declare(strict_types=1);

namespace Infra\EloquentModel\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use OwenIt\Auditing\Contracts\Auditable;

abstract class BaseModel extends EloquentModel implements Auditable
{
    use AuditableTrait, HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
