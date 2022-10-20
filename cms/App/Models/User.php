<?php

namespace App\Models;


use Crm\Models\Model;


class User extends Model
{
    public static $table = 'users';


    public static function posts(array $fields = ['*'])
    {
        return self::hasMany(Post::class, 'id', 'user_id', $fields);
    }
}
