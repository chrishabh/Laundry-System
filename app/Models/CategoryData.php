<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryData extends Model
{
    use HasFactory;

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];


    public static function getDashboardCategoryData()
    {
        $cotegories = Category::getCategoryData();
        $data = $return = [];
        foreach($cotegories as $categories_value){
          
            $category_data = CategoryData::whereNull('deleted_at')->where('category_id',$categories_value['id'])->get();

            if(count($category_data)>0){
                $category_data = $category_data->toArray();
            }else{
                $category_data = [];
            }
            $data['title'] = $categories_value['category'];
            $data['data'] =  $category_data;

            $return [] = $data;
        }

        return $return;

    }
}
