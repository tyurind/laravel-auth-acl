<?php

namespace Modules\Auth\Entities;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */

use Laratrust\Models\LaratrustPermission;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\AclPermissionTrait;

/**
 * Class BasePermission
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Auth\Entities\BaseRole[] $roles
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereGuard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BasePermission whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class BasePermission extends LaratrustPermission
{
    use AclPermissionTrait;

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
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.permissions');
        }
    }
}
