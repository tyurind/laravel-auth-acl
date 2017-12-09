<?php

namespace Modules\Auth\Traits;

use Laratrust\Traits\LaratrustUserTrait as BaseLaratrustUserTrait;
use Laratrust\Helper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait AclUserTrait
{
    use BaseLaratrustUserTrait;
    use AclGuardTrait;

    /**
     * Tries to return all the cached roles of the user.
     * If it can't bring the roles from the cache,
     * it brings them back from the DB.
     *
     * @return iterable
     */
    public function cachedRoles()
    {
        // $cacheKey = 'laratrust:roles_for_user_' . $this->getCacheKeyId();
        $cacheKey = $this->getCacheKey('laratrust:roles_for_user_');

        if (! Config::get('laratrust.use_cache')) {
            return $this->roles()->get();
        }

        return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->roles()->get()->toArray();
        });
    }

    /**
     * Tries to return all the cached permissions of the user
     * and if it can't bring the permissions from the cache,
     * it brings them back from the DB.
     *
     * @return iterable
     */
    public function cachedPermissions()
    {
        // $cacheKey = 'laratrust:permissions_for_user_' . $this->getCacheKeyId();
        $cacheKey = $this->getCacheKey('laratrust:permissions_for_user_');

        if (! Config::get('laratrust.use_cache')) {
            return $this->permissions()->get();
        }

        return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            return $this->permissions()->get()->toArray();
        });
    }

    /**
     * @return iterable
     */
    public function cachedAllPermissions()
    {
        $cacheKey = $this->getCacheKey('laratrust:all_permissions_for_user_');

        return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
            $roles = $this->roles()->with('permissions')->get();

            $roles = $roles->flatMap(function ($role) {
                return $role->permissions;
            });

            return $this->permissions->merge($roles)->unique('name')->toArray();
        });

        // $perm = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.permission'), $perm);
        // return $this->permissions()->get()->toArray();

        // ===========================
        // $cacheKey = 'laratrust:permissions_for_user_' . $this->getCacheKeyId();
        // $cacheKey = $this->getCacheKey('laratrust:permissions_for_user_');

        // if (! Config::get('laratrust.use_cache')) {
        //     return $this->permissions()->get();
        // }

        // return Cache::remember($cacheKey, Config::get('cache.ttl', 60), function () {
        //     return $this->permissions()->get()->toArray();
        // });
    }

    /**
     * Flush the user's cache.
     *
     * @return void
     */
    public function flushCache()
    {
        // Cache::forget('laratrust:roles_for_user_' . $this->getCacheKeyId());
        // Cache::forget('laratrust:permissions_for_user_' . $this->getCacheKeyId());
        Cache::forget($this->getCacheKey('laratrust:all_permissions_for_user_'));
        Cache::forget($this->getCacheKey('laratrust:roles_for_user_'));
        Cache::forget($this->getCacheKey('laratrust:permissions_for_user_'));

        unset($this->relations['allPermissions']);
    }

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function roles()
    {
        $roles = $this->morphToMany(
            $this->getLaratrustConfigKey('laratrust.models.role'),
            $this->getLaratrustConfigKey('laratrust.morph_prefix', 'user'), // user
            $this->getLaratrustConfigKey('laratrust.tables.role_user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.role')
        );

        if ($this->getLaratrustConfigKey('laratrust.use_teams')) {
            $roles->withPivot($this->getLaratrustConfigKey('laratrust.foreign_keys.team'));
        }

        return $roles;
    }

    /**
     * Many-to-Many relations with Permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function permissions()
    {
        $permissions = $this->morphToMany(
            $this->getLaratrustConfigKey('laratrust.models.permission'),
            $this->getLaratrustConfigKey('laratrust.morph_prefix', 'user'), // user
            $this->getLaratrustConfigKey('laratrust.tables.permission_user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.user'),
            $this->getLaratrustConfigKey('laratrust.foreign_keys.permission')
        );

        if ($this->getLaratrustConfigKey('laratrust.use_teams')) {
            $permissions->withPivot($this->getLaratrustConfigKey('laratrust.foreign_keys.team'));
        }

        return $permissions;
    }

    /**
     * Checks if the user has a role by its name.
     *
     * @param  string|array  $name       Role name or array of role names.
     * @param  string|bool   $team      Team name or requiredAll roles.
     * @param  bool          $requireAll All roles in the array are required.
     * @return bool
     */
    public function hasRole($name, $team = null, $requireAll = false)
    {
        $name = Helper::standardize($name);
        list($team, $requireAll) = Helper::assignRealValuesTo($team, $requireAll, 'is_bool');

        if (is_array($name)) {
            if (empty($name)) {
                return true;
            }

            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName, $team);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the roles were found.
            // If we've made it this far and $requireAll is TRUE, then ALL of the roles were found.
            // Return the value of $requireAll.
            return $requireAll;
        }

        $team = Helper::fetchTeam($team);

        foreach ($this->cachedRoles() as $role) {
            $role = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.role'), $role);

            if ($role->name == $name && Helper::isInSameTeam($role, $team)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has a permission by its name.
     *
     * @param  string|array  $permission Permission string or array of permissions.
     * @param  string|bool  $team      Team name or requiredAll roles.
     * @param  bool  $requireAll All roles in the array are required.
     * @return bool
     */
    public function hasPermission($permission, $team = null, $requireAll = false)
    {
        // \Debugbar::addMessage('hasPermission');
        $permission = Helper::standardize($permission);
        list($team, $requireAll) = Helper::assignRealValuesTo($team, $requireAll, 'is_bool');

        if (is_array($permission)) {
            if (empty($permission)) {
                return true;
            }

            foreach ($permission as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName, $team);

                if ($hasPermission && !$requireAll) {
                    return true;
                } elseif (!$hasPermission && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found.
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll.
            return $requireAll;
        }

        $team = Helper::fetchTeam($team);

        foreach ($this->allPermissions() as $perm) {
            if (Helper::isInSameTeam($perm, $team)
                && str_is($permission, $perm->name)) {
                return true;
            }
        }
        return false;

        foreach ($this->cachedPermissions() as $perm) {
            $perm = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.permission'), $perm);

            if (Helper::isInSameTeam($perm, $team)
                && str_is($permission, $perm->name)) {
                return true;
            }
        }

        foreach ($this->cachedRoles() as $role) {
            $role = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.role'), $role);

            if (Helper::isInSameTeam($role, $team)
                && $role->hasPermission($permission)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function allPermissions()
    {
        // \Debugbar::addMessage('allPermissions');

        if (array_key_exists('allPermissions', $this->relations)) {
            return $this->relations['allPermissions'];
        }

        $permission = collect();
        foreach ($this->cachedAllPermissions() as $perm) {
            $perm = Helper::hidrateModel($this->getLaratrustConfigKey('laratrust.models.permission'), $perm);

            $permission->push($perm);
        }
        $this->relations['allPermissions'] = $permission;

        return $permission;
    }
}
