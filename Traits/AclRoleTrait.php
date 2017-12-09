<?php

namespace Modules\Auth\Traits;

use Laratrust\Traits\LaratrustRoleTrait as BaseLaratrustRoleTrait;
use Laratrust\Helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait AclRoleTrait
{
    use AclGuardTrait;

    /**
     * Tries to return all the cached permissions of the role.
     * If it can't bring the permissions from the cache,
     * it brings them back from the DB.
     *
     * @return iterable
     */
    public function cachedPermissions()
    {
        // $cacheKey = 'laratrust:permissions_for_role_' . $this->getCacheKeyId();
        $cacheKey = $this->getCacheKey('laratrust:permissions_for_role_');

        if (! $this->getLaratrustConfigKey('laratrust.use_cache')) {
            return $this->permissions()->get();
        }

        return Cache::remember($cacheKey, $this->getLaratrustConfigKey('cache.ttl', 60), function () {
            return $this->permissions()->get()->toArray();
        });
    }

    /**
     * Flush the role's cache.
     *
     * @return void
     */
    public function flushCache()
    {
        $cacheKey = $this->getCacheKey('laratrust:permissions_for_role_');
        Cache::forget($cacheKey);
    }

    /**
     * Morph by Many relationship between the role and the one of the possible user models.
     *
     * @param  string  $relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function getMorphByUserRelation($relationship)
    {
        return $this->morphedByMany(
            $this->getLaratrustConfigKey('laratrust.user_models')[$relationship],
            $this->getLaratrustConfigKey('laratrust.morph_prefix', 'user'), // user
            $this->getLaratrustConfigKey('laratrust.tables.role_user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.role'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.user')
        );
    }

    /**
     * Many-to-Many relations with the permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            $this->getLaratrustConfigKey('laratrust.models.permission'),
            $this->getLaratrustConfigKey('laratrust.tables.permission_role'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.role'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.permission')
        );
    }

    /**
     * Checks if the role has a permission by its name.
     *
     * @param  string|array  $permission       Permission name or array of permission names.
     * @param  bool  $requireAll       All permissions in the array are required.
     * @return bool
     */
    public function hasPermission($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            if (empty($permission)) {
                return true;
            }

            foreach ($permission as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);

                if ($hasPermission && !$requireAll) {
                    return true;
                } elseif (!$hasPermission && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the permissions were found.
            // If we've made it this far and $requireAll is TRUE, then ALL of the permissions were found.
            // Return the value of $requireAll.
            return $requireAll;
        }

        foreach ($this->cachedPermissions() as $perm) {
            $perm = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.permission'), $perm);

            if (str_is($permission, $perm->name)) {
                return true;
            }
        }

        return false;
    }
}
