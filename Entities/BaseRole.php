<?php

namespace Modules\Auth\Entities;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\AclRoleTrait;

/**
 * Class BaseRole
 *
 * @property int $id
 * @property string $guard
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\BasePermission[] $permissions
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereGuard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRole whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class BaseRole extends LaratrustRole
{
    use AclRoleTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        Model::__construct($attributes);
        if (empty($this->table)) {
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.roles');
        }
    }
}
