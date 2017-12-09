<?php

namespace Modules\Auth\Entities\Acl;

use Modules\Auth\Traits\AclTeamTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustTeam;

/**
 * Modules\Auth\Entities\Acl\AclTeam
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Auth\Entities\Acl\AclTeam whereUpdatedAt($value)
 */
class AclTeam extends LaratrustTeam
{
    use AclTeamTrait;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    // protected $table = 'acl_teams';

    public function __construct(array $attributes = [])
    {
        // Model::__construct($attributes);
        parent::__construct($attributes);
        $this->table = $this->getLaratrustConfigKey('laratrust.tables.teams');
    }
}
