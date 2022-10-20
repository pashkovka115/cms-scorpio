<?php

namespace App\Models;


use Crm\Models\Model;


class Post extends Model
{
    public static $table = 'posts';


    public static function user(array $fields = ['*'])
    {
        return self::hasOne(User::class, 'user_id', 'id', $fields);
    }
}
