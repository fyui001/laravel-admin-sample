<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
use Domain\Common\UserRole;
use Domain\Common\UserStatus;

class AdminUser
{
    private AdminId $id;
    private AdminUserId $userId;
    private HashedPassword $hashedPassword;
    private PeopleName $name;
    private UserRole $role;
    private UserStatus $status;

    public function __construct(
        AdminId $id,
        AdminUserId $userId,
        ?HashedPassword $hashedPassword,
        PeopleName $name,
        UserRole $role,
        UserStatus $status
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->hashedPassword = $hashedPassword;
        $this->name = $name;
        $this->role = $role;
        $this->status = $status;
    }

    public static function makeDummy(
        ?AdminId $id = null,
        ?AdminUserId $userId,
        ?PeopleName $name = null,
        ?HashedPassword $hashedPassword = null,
        ?UserRole $role = null,
        ?UserStatus $status = null
    ): self {
        return new self(
            $id ?? new AdminId(1),
            $userId ?? new AdminUserId('takada_yuki'),
            $hashedPassword ?? new HashedPassword('dummy'),
            $name ?? new PeopleName('高田憂希'),
            $role ?? new UserRole(UserRole::ROLE_SYSTEM),
        $status ?? new UserStatus(UserStatus::STATUS_VALID)
        );
    }

    public function getId(): AdminId
    {
        return $this->id;
    }

    public function getUserId(): AdminUserId
    {
        return $this->userId;
    }

    public function getName(): PeopleName
    {
        return $this->name;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->rawValue(),
            'userId' - $this->userId->rawValue(),
            'name' => $this->name->rawValue(),
            'role' => $this->role->rawValue(),
            'status' => $this->status->rawValue(),
        ];
    }

    public function getHashedPassword(): ?HashedPassword
    {
        return $this->hashedPassword;
    }

    public function hasHashedPassword(): bool
    {
        return !is_null($this->hashedPassword);
    }
}
