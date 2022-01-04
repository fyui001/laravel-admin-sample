<?php

declare(strict_types=1);

namespace Domain\AdminUser\AdminUserRepositoryArgument;

use Domain\AdminUser\AdminUserId;
use Domain\Common\HashedPassword;
use Domain\Common\PeopleName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;

class AdminUserArgumentForCreate
{
    public AdminUserId $adminUserId;
    public HashedPassword $hashedPassword;
    public PeopleName $name;
    public AdminUserRole $role;
    public AdminUserStatus $status;

    public function __construct(
        AdminUserId    $adminUserId,
        HashedPassword $hashedPassword,
        PeopleName     $name,
        AdminUserRole  $role,
        AdminUserStatus $status
    ){
        $this->adminUserId = $adminUserId;
        $this->hashedPassword = $hashedPassword;
        $this->name = $name;
        $this->role = $role;
        $this->status = $status;
    }
}
