<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public static function getCategoryData()
    {
        $return = Category::whereNull('deleted_at')->get();

        if(count($return)>0){
            return $return->toArray();
        }

        return [];
    }
}
