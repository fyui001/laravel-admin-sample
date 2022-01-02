<?php

namespace Domain\Base;

use Domain\Common\Day;
use Domain\Common\Month;
use Domain\Common\Year;

abstract class BaseTime
{
    private $timestamp;

    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public static function fromString($string)
    {
        return new static(strtotime($string));
    }

    public static function now()
    {
        return new static(time());
    }

    public function isEqual(BaseTime $another): bool
    {
        return $this->timestamp === $another->timestamp;
    }

    public function isEqualDay(BaseTime $another): bool
    {
        return $this->atHour(0)->isEqual($another->atHour(0));
    }

    public function atHour(int $hour)
    {
        return new static(strtotime(date('Y-m-d ' . $hour . ':00:00', $this->timestamp)));
    }

    public function startOfHour(): self
    {
        return new static(strtotime(date('Y-m-d H' . ':00:00', $this->timestamp)));
    }

    public function endOfHour(): self
    {
        return new static(strtotime(date('Y-m-d H' . ':59:59', $this->timestamp)));
    }

    public function startOfDay(): self
    {
        return new static(strtotime(date('Y-m-d ' . '00:00:00', $this->timestamp)));
    }

    public function endOfDay(): self
    {
        return new static(strtotime(date('Y-m-d ' . '23:59:59', $this->timestamp)));
    }

    public function day()
    {
        return new static(strtotime(date('Y-m-d', $this->timestamp)));
    }

    public function timeStamp(): int
    {
        return $this->timestamp;
    }

    public function getDay(): Day
    {
        return new Day(intval(date('d', $this->timestamp)));
    }

    public function getMonth(): Month
    {
        return new Month(intval(date('m', $this->timestamp)));
    }

    public function getYear(): Year
    {
        return new Year(intval(date('Y', $this->timestamp)));
    }

    public function getHour(): string
    {
        return date('H', $this->timestamp);
    }

    public function getWithTime(): string
    {
        return date('m/d H:i', $this->timestamp);
    }

    public function getDisplayName(): string
    {
        return date('Y/m/d', $this->timestamp);
    }

    public function getFormattedDate(string $format): string
    {
        return date($format, $this->timestamp);
    }

    public function rawValue()
    {
        return $this->timestamp;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }
}
