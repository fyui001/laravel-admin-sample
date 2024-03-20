<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database;

/**
 * This class contains shared setup, properties and methods
 * of all application models
 *
 */
abstract class BaseModel extends EloquentModel
{
    use Database\Eloquent\Factories\HasFactory;

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

    /**
     * LIKE句のSQLインジェクション対策用クエリスコープ
     * @see https://qiita.com/fyui001/items/f7574eeab7c6145ea80a
     *
     * @param $query
     * @param string $attribute
     * @param string $keyword
     * @param int $position
     * @return mixed
     */
    public function scopeWhereLike($query, string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
            1  => "{$keyword}%",
            -1 => "%{$keyword}",
        ][$position] ?? "%{$keyword}%";

        return $query->where($attribute, 'LIKE', $condition);
    }

    /**
     * LIKE句のSQLインジェクション対策用クエリスコープ
     * @see https://qiita.com/fyui001/items/f7574eeab7c6145ea80a
     *
     * @param $query
     * @param string $attribute
     * @param string $keyword
     * @param int $position
     * @return mixed
     */
    public function scopeOrWhereLike($query, string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
            1  => "{$keyword}%",
            -1 => "%{$keyword}",
        ][$position] ?? "%{$keyword}%";

        return $query->orWhere($attribute, 'LIKE', $condition);
    }
}
