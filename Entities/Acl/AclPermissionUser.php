<?php

namespace Modules\Auth\Entities\Acl;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AclPermissionUser
 *
 * @mixin \Eloquent
 * @property int $permission_id
 * @property int $user_id
 * @property string $user_type
 * @property int|null $team_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionUser wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionUser whereUserType($value)
 */
class AclPermissionUser extends Model
{
    // protected $table = 'acl_permission_user';

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
        // Model::__construct($attributes);
        parent::__construct($attributes);
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.permission_user');
    }
}
