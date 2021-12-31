<?php

namespace Infra\EloquentFilter;

use Domain\Common\Sequence\Filter\CompositeFilterRule;
use Domain\Common\Sequence\Filter\FilterRule;
use Domain\Common\Sequence\Filter\LeafFilterRule;
use Domain\Exception\LogicException;
use Illuminate\Database\Eloquent\Builder;

class EloquentFilterHelper
{
    public static function apply(Builder &$model, FilterRule $filter): void
    {
        if ($filter instanceof CompositeFilterRule) {

            $model->where(function (Builder $query) use ($filter) {
                $filter->forEach(function ($rule) use (&$query, $filter) {
                    self::applyRule($query, $rule, $filter->expression());
                });
            });

            return;
        }

        if ($filter instanceof LeafFilterRule) {
            self::applyAnd($model, $filter);
            return;
        }

        throw new LogicException('Not implements');
    }

    private static function applyRule(Builder &$model, FilterRule $rule, string $expression): void
    {
        if ($expression === CompositeFilterRule::EXPRESSION_OR) {
            self::applyOr($model, $rule);
        } else {
            self::applyAnd($model, $rule);
        }
    }

    private static function applyOr(Builder &$model, FilterRule $rule): void
    {
        // FIXME: 複雑なメソッドを分解してほしい
        if ($rule instanceof CompositeFilterRule) {
            $model->orWhere(function ($builder) use ($rule) {
                foreach ($rule->rules() as $nestedRule) {
                    if ($rule->expression() == CompositeFilterRule:: EXPRESSION_OR) {
                        self::applyOr($builder, $nestedRule);
                    } else {
                        self::applyAnd($builder, $nestedRule);
                    }
                }
            });
            return;
        }

        if ($rule->operator() === LeafFilterRule::OPERATOR_IN) {
            $model->orWhereIn($rule->name(), $rule->value());
            return;
        }

        if ($rule->operator() === LeafFilterRule::LIKE) {
            $model->orWhere($rule->name(), 'like', '%' . $rule->value() . '%');
            return;
        }

        if ($rule->value() === LeafFilterRule::VALUE_NULL) {
            $model->orWhereNull($rule->name());
            return;
        }

        if ($rule->value() === LeafFilterRule::VALUE_NOT_NULL) {
            $model->orWhereNotNull($rule->name());
            return;
        }

        $model->orWhere($rule->name(), $rule->operator(), $rule->value());
    }

    private static function applyAnd(Builder &$model, FilterRule $rule): void
    {
        // FIXME: 複雑なメソッドを分解してほしい
        if ($rule instanceof CompositeFilterRule) {
            $model->where(function ($builder) use ($rule) {
                foreach ($rule->rules() as $nestedRule) {
                    if ($rule->expression() == CompositeFilterRule:: EXPRESSION_OR) {
                        self::applyOr($builder, $nestedRule);
                    } else {
                        self::applyAnd($builder, $nestedRule);
                    }
                }
            });
            return;
        }

        if ($rule->operator() === LeafFilterRule::OPERATOR_IN) {
            $model->whereIn($rule->name(), $rule->value());
            return;
        }

        if ($rule->operator() === LeafFilterRule::LIKE) {
            $model->where($rule->name(), 'like', '%' . $rule->value() . '%');
            return;
        }

        if ($rule->value() === LeafFilterRule::VALUE_NULL) {
            $model->whereNull($rule->name());
            return;
        }

        if ($rule->value() === LeafFilterRule::VALUE_NOT_NULL) {
            $model->whereNotNull($rule->name());
            return;
        }


        $model->where($rule->name(), $rule->operator(), $rule->value());
    }
}
