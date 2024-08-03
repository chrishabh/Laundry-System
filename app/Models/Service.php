<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public static function getDashboardServiceData()
    {
        $services = Service::whereNull('deleted_at')->get();
        if(count($services)>0){
            $services = $services->toArray();
        }else{
            return [];
        }
        $data = $return = [];
        $services_group_by = group_by('service', $services);

        foreach($services_group_by as $key => $services_value){

            $data['title'] = $key;
            $data['data'] = $services_group_by[$key];

            $return [] = $data;
        }

        return $return;
    }
}
