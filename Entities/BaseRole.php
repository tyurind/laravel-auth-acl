<?php

namespace Modules\Auth\Entities;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Laratrust
 */

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\AclRoleTrait;

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
