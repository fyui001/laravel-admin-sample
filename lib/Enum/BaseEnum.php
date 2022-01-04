<?php
declare(strict_types=1);

namespace Lib\Enum;

abstract class BaseEnum
{
    private $scalar;

    public function __construct($value)
    {
        if (!static::canConvert($value)) {
            $entity = is_object($value) ? get_class($value) : strval($value);
            throw new \Exception("{$entity}: Undefined value in enum object");
        }

        $this->scalar = $value;
    }

    public static function canConvert($value): bool
    {
        $ref = new \ReflectionClass(static::class);
        $constants = $ref->getConstants();

        return in_array($value, $constants, true);
    }

    abstract public function displayName(): string;

    final public static function __callStatic($label, $args)
    {
        $class = get_called_class();
        $const = constant("$class::$label");
        return new $class($const);
    }

    final public function rawValue()
    {
        return $this->scalar;
    }

    final public function __toString()
    {
        return $this->displayName();
    }

    public function is($another): bool
    {
        return $this->rawValue() === $another;
    }

    public function equals(BaseEnum $another): bool
    {
        return $this->rawValue() == $another->rawValue();
    }

    public static function getConstants(): array
    {
        $ref = new \ReflectionClass(static::class);
        return $ref->getConstants();
    }

    public static function getCommaSeparatedConstants(): string
    {
        return implode(',', self::getConstants());
    }

    public static function getRawValueList(): array
    {
        $ref = new \ReflectionClass(static::class);
        $constants = $ref->getConstants();

        $array = [];
        foreach ($constants as $key => $value) {
            if (!is_string($value) && !is_int($value)) {
                continue;
            }
            $array[] = $value;
        }
        return $array;
    }

    protected static function getAllArray(): array
    {
        $ref = new \ReflectionClass(static::class);
        $constants = $ref->getConstants();
        $array = [];
        foreach ($constants as $key => $value) {
            if (!is_string($value) && !is_int($value)) {
                continue;
            }
            $class = static::class;
            $array[] = new $class($value);
        }

        return $array;
    }

    public static function optionList()
    {
        $ref = new \ReflectionClass(static::class);
        $constants = $ref->getConstants();
        $list = [];
        foreach ($constants as $key => $value) {
            if (!is_string($value) && !is_int($value)) {
                continue;
            }
            $class = static::class;
            $type = new $class($value);
            $list[$value] = $type->displayName();
        }

        return $list;
    }

    public static function getAllObjectArray(): array
    {
        return array_map(static function (string $keyName) {
            return new static($keyName);
        }, static::getRawValueList());
    }

    public static function isExist($input): bool
    {
        return array_key_exists($input, self::optionList());
    }
}
