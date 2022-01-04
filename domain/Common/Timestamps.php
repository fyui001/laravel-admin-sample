<?php
declare(strict_types=1);

namespace Domain\Common;

class Timestamps
{
    /**
     * @var UpdatedAt
     */
    private $updatedAt;
    /**
     * @var CreatedAt
     */
    private $createdAt;


    /**
     * Timestamps constructor.
     */
    public function __construct(
        UpdatedAt $updatedAt,
        CreatedAt $createdAt
    ) {
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @return UpdatedAt
     */
    public function getUpdatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @return CreatedAt
     */
    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public static function makeDummy(): self
    {
        return new self(UpdatedAt::now(), CreatedAt::now());
    }
}
