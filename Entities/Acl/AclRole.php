<?php

namespace Modules\Auth\Entities\Acl;

use Modules\Auth\Traits\AclRoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;

/**
 * Class AclRole
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\Acl\AclPermission[] $permissions
 * @mixin \Eloquent
 * @property int $id
 * @property string $guard
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereGuard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRole whereUpdatedAt($value)
 */
class AclRole extends LaratrustRole
{
    use AclRoleTrait;
    use SoftDeletes;

    // protected $table = 'acl_roles';

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
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.roles');
    }
}
