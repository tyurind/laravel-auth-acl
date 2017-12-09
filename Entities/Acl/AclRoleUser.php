<?php

namespace Modules\Auth\Entities\Acl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class AclRoleUser
 *
 * @mixin \Eloquent
 * @property int $role_id
 * @property int $user_id
 * @property string $user_type
 * @property int|null $team_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRoleUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRoleUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRoleUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclRoleUser whereUserType($value)
 */
class AclRoleUser extends Model
{
    // protected $table = 'acl_role_user';

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
        // Model::__construct($attributes);
        parent::__construct($attributes);
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.role_user');
    }
}
