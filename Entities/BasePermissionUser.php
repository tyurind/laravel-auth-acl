<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\AclGuardTrait;

/**
 * Class BasePermissionUser
 *
 * @property int $permission_id
 * @property int $user_id
 * @property string $user_type
 * @property int|null $team_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionUser wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionUser whereUserType($value)
 *
 * @mixin \Eloquent
 */
class BasePermissionUser extends Model
{
    use AclGuardTrait;

    protected $table;

    public $timestamps = false;

    public $incrementing = false;
    public $primaryKey = null;

    protected $fillable = [
        'permission_id',
        'user_id',
        'user_type',
    ];

    protected $guarded = [];


    public function __construct(array $attributes = [])
    {
        Model::__construct($attributes);
        if (empty($this->table)) {
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.permission_user');
        }
    }
}
