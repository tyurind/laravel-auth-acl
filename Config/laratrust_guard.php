<?php

return [
    'defaults' => [
        'providers' => 'users',
    ],

    'providers' => [
        /*
        'users' => [
            'models' => [
                'role' => 'App\Models\Acl\AclRole',
                'permission' => 'App\Models\Acl\AclPermission',
                'team' => 'App\Models\Acl\AclTeam',
            ],
            'tables' => [
                'roles' => 'acl_roles',
                'permissions' => 'acl_permissions',
                'teams' => 'acl_teams',
                'role_user' => 'acl_role_user',
                'permission_user' => 'acl_permission_user',
                'permission_role' => 'acl_permission_role',
            ],
            'foreign_keys' => [
                'user' => 'user_id',
                'role' => 'role_id',
                'permission' => 'permission_id',
                'team' => 'team_id',
            ]
        ], /**/

        // 'admins' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
];
