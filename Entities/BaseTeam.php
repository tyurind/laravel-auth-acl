<?php

namespace Modules\Auth\Entities;

use Laratrust\Models\LaratrustTeam;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\AclTeamTrait;

/**
 * This file is part of Laratrust,
 * a role & permission management solution for Laravel.
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseTeam whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class BaseTeam extends LaratrustTeam
{
    use AclTeamTrait;

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
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.teams');
        }
    }
}
