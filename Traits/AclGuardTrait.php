<?php
/**
 * LaratrustGuardTrait.php file
 */

namespace Modules\Auth\Traits;

use Illuminate\Support\Facades\Config;


/**
 * Class LaratrustGuardTrait
 */
trait AclGuardTrait
{
    public function getAuthGuard()
    {
        return isset($this->authGuard) ? $this->authGuard : '';
    }

    public function getLaratrustConfigKey($key, $default = null)
    {
        $prefix = $this->getAuthGuard();
        $defaultKey = null;
        if ($prefix) {
            $defaultKey = $key;
            $key = str_replace('laratrust.', 'laratrust_guard.providers.' . $prefix . '.', $key);
        }
        return Config::get($key, $defaultKey ?  Config::get($defaultKey, $default) : $default);
    }

    public function getCacheKeyId()
    {
        return $this->getTable() . ':' . $this->getKey();
    }

    public function getCacheKey($key)
    {
        return $key . ':' .  $this->getCacheKeyId();
    }
}
