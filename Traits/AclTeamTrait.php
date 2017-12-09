<?php

namespace Modules\Auth\Traits;

use Laratrust\Traits\LaratrustTeamTrait as BaseLaratrustTeamTrait;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */
trait AclTeamTrait
{
    use BaseLaratrustTeamTrait;
    use AclGuardTrait;

    /**
     * Morph by Many relationship between the role and the one of the possible user models.
     *
     * @param  string $relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship)
    {
        return $this->morphedByMany(
            $this->getLaratrustConfigKey('laratrust.user_models')[$relationship],
            $this->getLaratrustConfigKey('laratrust.morph_prefix', 'user'), // user
            $this->getLaratrustConfigKey('laratrust.tables.role_user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.team'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.user')
        );
    }
}
