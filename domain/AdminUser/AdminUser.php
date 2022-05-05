<?php

declare(strict_types=1);

namespace Domain\AdminUser;

class AdminUser
{
    private AdminId $id;
    private AdminUserId $adminUserId;
    private AdminUserName $adminUserName;
    private AdminUserRole $role;
    private AdminUserStatus $status;

    public function __construct(
        AdminId $id,
        AdminUserId $adminUserId,
        AdminUserName $adminUserName,
        AdminUserRole $role,
        AdminUserStatus $status
    ) {
        $this->id = $id;
        $this->adminUserId = $adminUserId;
        $this->adminUserName = $adminUserName;
        $this->role = $role;
        $this->status = $status;
    }

    public static function makeDummy(
        ?AdminId $id,
        ?AdminUserId $adminUserId,
        ?AdminUserName $adminUserName,
        ?AdminUserRole $role,
        ?AdminUserStatus $status
    ): self {
        return new self(
            $id ?? new AdminId(1),
            $adminUserId ?? new AdminUserId('takada_yuki'),
            $adminUserName ?? new AdminUserName('高田憂希'),
            $role ?? AdminUserRole::tryFrom(AdminUserRole::ROLE_SYSTEM->getValue()->getRawValue()),
        $status ?? AdminUserStatus::tryFrom(AdminUserStatus::STATUS_VALID->getValue()->getRawValue())
        );
    }

    public function getId(): AdminId
    {
        return $this->id;
    }

    public function getUserId(): AdminUserId
    {
        return $this->adminUserId;
    }

    public function getName(): AdminUserName
    {
        return $this->adminUserName;
    }

    public function getRole(): AdminUserRole
    {
        return $this->role;
    }

    public function getStatus(): AdminUserStatus
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getRawValue(),
            'userId' - $this->adminUserId->getRawValue(),
            'name' => $this->adminUserName->getRawValue(),
            'role' => $this->role->getValue()->getRawValue(),
            'status' => $this->status->getValue()->getRawValue(),
        ];
    }
}
