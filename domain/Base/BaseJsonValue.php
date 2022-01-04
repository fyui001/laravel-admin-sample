<?php
declare(strict_types=1);

namespace Domain\Base;

class BaseJsonValue extends BaseValue
{
    private function __construct(array $array)
    {
        $this->value = $array;
    }

    public static function makeEmpty(): self
    {
        return new static([]);
    }

    public static function makeFromEncodedString(string $encodedString): self
    {
        return new static(json_decode($encodedString, true));
    }

    public function addNode(string $key, $value): self
    {
        return new static(array_add($this->value, $key, $value));
    }

    public function getEncoded(): string
    {
        return json_encode($this->value, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
    }
}
