<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Auth\Traits\AclGuardTrait;

/**
 * Class AclRoleUser
 *
 * @property int $role_id
 * @property int $user_id
 * @property string $user_type
 * @property int|null $team_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRoleUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRoleUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRoleUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\BaseRoleUser whereUserType($value)
 *
 * @mixin \Eloquent
 */
class BaseRoleUser extends Model
{
    use AclGuardTrait;

    protected $table;

    public $incrementing = false;

    public $primaryKey = null;

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'user_id',
        'user_type'
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        Model::__construct($attributes);
        if (empty($this->table)) {
            $this->table = $this->getLaratrustConfigKey('laratrust.tables.role_user');
        }
    }
}
