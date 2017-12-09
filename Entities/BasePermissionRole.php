<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Auth\Traits\AclGuardTrait;

/**
 * Class BasePermissionRole
 *
 * @property int $permission_id
 * @property int $role_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermissionRole whereRoleId($value)
 *
 * @mixin \Eloquent
 */
class BasePermissionRole extends Model
{
    use AclGuardTrait;

    protected $table;

    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = null;

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        Model::__construct($attributes);
        if (empty($this->table)) {
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.permission_role');
        }
    }
}
