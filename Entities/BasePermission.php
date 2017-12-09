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
 * Class LaratrustPermission
 * @author     Dmitriy Tyurin <fobia3d@gmail.com>
 * @copyright  Copyright (c) 2016 Dmitriy Tyurin
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
