<?php

declare(strict_types=1);

namespace Domain\AdminUser\AdminUserRepositoryArgument;

use Domain\AdminUser\AdminUserId;
use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
use Domain\Common\UserRole;
use Domain\Common\UserStatus;

class AdminUserArgumentForCreate
{
    public AdminUserId $adminUserId;
    public HashedPassword $hashedPassword;
    public PeopleName $name;
    public UserRole $role;
    public UserStatus $status;

    public function __construct(
        AdminUserId $adminUserId,
        HashedPassword $hashedPassword,
        PeopleName $name,
        UserRole $role,
        UserStatus $status
    ){
        $this->adminUserId = $adminUserId;
        $this->hashedPassword = $hashedPassword;
        $this->name = $name;
        $this->role = $role;
        $this->status = $status;
    }
}
