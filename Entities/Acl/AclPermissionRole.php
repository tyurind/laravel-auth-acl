<?php

namespace Modules\Auth\Entities\Acl;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AclPermissionRole
 *
 * @mixin \Eloquent
 * @property int $permission_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermissionRole whereRoleId($value)
 */
class AclPermissionRole extends Model
{
    // protected $table = 'acl_permission_role';

    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = null;

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        // Model::__construct($attributes);
        parent::__construct($attributes);
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.permission_role');
    }
}
