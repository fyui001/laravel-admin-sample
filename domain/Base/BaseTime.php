<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoInt\CoInteger;
use Domain\Exception\InvalidArgumentException;

abstract class BaseTime extends CoInteger
{
    public function __construct(private int $timestamp)
    {
        parent::__construct($this->timestamp);
    }

    public static function forStringTime(string $stringTime): static
    {
        $time = strtotime($stringTime);
        if (!$time) {
            throw new InvalidArgumentException();
        }

        return new static($time);
    }

    public static function forStringDate(string $stringDate, bool $null = false): static
    {
        $date = date($stringDate);

        return self::forStringTime($date, $null);
    }


    public static function now(): static
    {
        return new static(time());
    }

    public function timeStamp(): int
    {
        return $this->timestamp;
    }

    public function getDisplay(): string
    {
        return date('Y/m/d', $this->timestamp);
    }

    public function getDetail(): string
    {
        return date('Y/m/d H:i:s', $this->timestamp);
    }

    public function getSqlDate(): string
    {
        return date('Y-m-d', $this->timestamp);
    }

    public function getSqlTimeStamp(): string
    {
        return date('Y-m-d H:i:s', $this->timestamp);
    }

    public function addSeconds(int $second): static
    {
        return new static(
            strtotime('+' . $second . 'second', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid second or timestamp.')
        );
    }

    public function addMinutes(int $minute): static
    {
        return new static(
            strtotime('+' . $minute . 'minute', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid minute or timestamp.')
        );
    }

    public function addHour(int $hour): static
    {
        return new static(
            strtotime('+' . $hour . 'hour', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid hour or timestamp.')
        );
    }

    public function addDay(int $day): static
    {
        return new static(
            strtotime('+' . $day . 'day', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid day or timestamp.')
        );
    }

    public function subDay(int $day): static
    {
        return new static(
            strtotime('-' . $day . 'day', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid day or timestamp.')
        );
    }

    public function subMonth(int $month): static
    {
        return new static(
            strtotime('-' . $month . 'month', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid month or timestamp.')
        );
    }

    public function subWeek(int $week): static
    {
        return new static(
            strtotime('-' . $week . 'week', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid week or timestamp.')
        );
    }

    public function subHour(int $hour): static
    {
        return new static(
            strtotime('-' . $hour . 'hour', $this->timestamp()) ?:
                throw new \InvalidArgumentException('Invalid hour or timestamp.')
        );
    }

    public function getFirstDayOfThisMonth(): static
    {
        return new static(strtotime('first day of this month', $this->timestamp));
    }

    public function getFirstDayOfPreviousMonth(): static
    {
        return new static(strtotime('first day of previous month', $this->timestamp));
    }

    public function getFirstDayOfSpecifiedMonth(int $specifiedMonth): static
    {
        return new static(
            strtotime("first day of {$specifiedMonth} months ago", $this->timestamp) ?:
                throw new \InvalidArgumentException('Invalid specifiedMonth or timestamp.')
        );
    }

    public function getStartOfDay(): static
    {
        return new static(strtotime('today', $this->timestamp));
    }

    public function getEndOfDay(): static
    {
        return new static(strtotime('tomorrow', strtotime('today', $this->timestamp)) - 1);
    }

    public function makeToDateTimeInterface(): DateTime
    {
        $date = new DateTimeImmutable($this->getSqlTimeStamp());
        return DateTime::createFromInterface($date);
    }

    public function getIsoString(): string
    {
        return date('c', $this->timestamp);
    }

    public function __toString(): string
    {
        return $this->getDisplay();
    }
}
