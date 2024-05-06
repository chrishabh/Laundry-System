<?php

use App\Exceptions\AppException;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Filters\ChunkReadFilter;

function pp($arr, $die="true")
	{
			echo '<pre>';
			print_r($arr);
			echo '</pre>';
			if($die == 'true')
			{
				die();
			}
	}
	function _print_r($array)
	{
		echo "<pre>";
		echo print_r($array);
		echo "<pre>";
	}

if (! function_exists('envparam')) {

	function envparam($key = null, $default = null)
    {
		if(empty($key))
		{
			return config($key,$default);
		}


        $configVal = config("env.".$key,$default);
		
		if(empty($configVal))
        {
            throw new AppException("No  envparam value found for key '$key'");
        }

        return $configVal;
	}
}
	function customiseLookupsData($array)
    {
    	foreach ($array as $key => &$value) {
            if($key == 'displaytext'){

        		$result_array = [];
        		foreach ($value as $k => $val) {
        			$result_array[$val['key']] = $val['text'];
        		}
        		$array[$key] = $result_array;
            }else{
                foreach ($value as $k => &$val) {
                    unset($val['type']);
                }
            }
    	}

        return $array;
    }

	function group_by($key, $data) {
        $result = array();
        foreach($data as &$val) {
            $val = (array)$val;
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
        return $result;
    }

    function isEmptyArray($data = []){
        foreach($data as $value){
            if(!empty($value)){
                return true;
            }
        }
        return false;
    }

    function roundOff($number,$upto =2){

        $number=(double)$number;
        $return=round($number,$upto);
        return $return;
    }

    function checkUserRole($user_id)
    {
        return User::getUserById($user_id)['user_role'];
    }

?>