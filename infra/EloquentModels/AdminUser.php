<?php
declare(strict_types=1);

namespace Infra\EloquentModels;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Domain\Base\Domainable;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\Common\PeopleName;
use Domain\Common\HashedPassword;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;

class AdminUser extends Authenticatable implements Domainable
{
    use Notifiable;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    public function toDomain(): AdminUserDomain
    {
        return new AdminUserDomain(
            new AdminId($this->id),
            new AdminUserId($this->user_id),
            new HashedPassword($this->password),
            new PeopleName($this->name),
            new AdminUserRole($this->role),
            new AdminUserStatus($this->status)
        );
    }
}
