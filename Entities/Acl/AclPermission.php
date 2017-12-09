<?php

namespace Modules\Auth\Entities\Acl;

use Modules\Auth\Traits\AclPermissionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustPermission;

/**
 * Class AclPermission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Acl\AclRole[] $roles
 * @mixin \Eloquent
 * @property int $id
 * @property string $guard
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereGuard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclPermission whereUpdatedAt($value)
 */
class AclPermission extends LaratrustPermission
{
    use AclPermissionTrait;
    use SoftDeletes;

    // protected $table = 'acl_permissions';

    public $timestamps = true;

    protected $fillable = [
        'guard',
        'name',
        'display_name',
        'description'
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        // Model::__construct($attributes);
        parent::__construct($attributes);
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.permissions');
    }
}
