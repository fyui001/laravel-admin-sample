<?php
declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\AdminUser\AdminUserName;
use Domain\Common\HashedPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;

/**
 * Infra\EloquentModels\AdminUser
 *
 * @property int $id id
 * @property string $user_id 管理者ID
 * @property string $password パスワード
 * @property string $name 名前
 * @property string $role ロール
 * @property string $status ステータス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUserId($value)
 * @mixin \Eloquent
 */
class AdminUser extends Authenticatable
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
            new AdminUserName($this->name),
            AdminUserRole::tryFrom($this->role),
            AdminUserStatus::tryFrom($this->status)
        );
    }
}
