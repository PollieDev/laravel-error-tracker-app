<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Role extends Model
{

    use Sushi;
    static $ADMIN = 1;
    static $DEVELOPER = 2;
    static $GUEST = 0;

    protected $rows = [
        [
            'id'   => 1,
            'name' => 'Admin',
            'powerlevel' => 100
        ],
        [
            'id'   => 2,
            'name' => 'Developer',
            'powerlevel' => 50
        ],
        [
            'id' => 0,
            'name' => 'Guest',
            'powerlevel' => 0
        ]
    ];

}
