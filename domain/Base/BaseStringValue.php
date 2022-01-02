<?php
declare(strict_types=1);

namespace Domain\Base;

abstract class BaseStringValue extends BaseValue
{
    protected $value;

    const RANDOM_STR_CHAR_SET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function makeDummy(): self
    {
        return new static('ダミーテキスト');
    }

    public function rawValue(): string
    {
        return $this->value;
    }

    public function equals(BaseStringValue $another): bool
    {
        return $this->value === $another->rawValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isTextEmpty(): bool
    {
        return mb_strlen(trim($this->value)) == 0;
    }

    public static function makeRandomString(int $length): string
    {
        return self::makeRandStr($length, self::RANDOM_STR_CHAR_SET);
    }

    protected static function makeRandStr(int $length, string $charSet): string
    {
        $retStr = '';
        $randMax =  strlen($charSet) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $retStr .= $charSet[rand(0, $randMax)];
        }
        return $retStr;
    }
}
