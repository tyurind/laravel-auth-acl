<?php

namespace Modules\Auth\Traits;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */

use Illuminate\Support\Facades\Config;
use Laratrust\Traits\LaratrustDynamicUserRelationsCalls;
use Laratrust\Traits\LaratrustPermissionTrait as BaseLaratrustPermissionTrait;

trait AclPermissionTrait
{
    use BaseLaratrustPermissionTrait;
    use AclGuardTrait;

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            $this->getLaratrustConfigKey('laratrust.models.role'),
            $this->getLaratrustConfigKey('laratrust.tables.permission_role'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.permission'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.role')
        );
    }

    /**
     * Morph by Many relationship between the permission and the one of the possible user models.
     *
     * @param  string  $relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship)
    {
        return $this->morphedByMany(
            $this->getLaratrustConfigKey('laratrust.user_models')[$relationship],
            $this->getLaratrustConfigKey('laratrust.morph_prefix', 'user'), // user
            $this->getLaratrustConfigKey('laratrust.tables.permission_user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.permission'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.user')
        );
    }
}
