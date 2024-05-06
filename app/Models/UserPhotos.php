<?php

namespace App\Models;

use App\Exceptions\AppException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPhotos extends Model
{
    use HasFactory;


    public static function uploadPhoto($request)
    {
        if(UserPhotos::whereNull('deleted_at')->where('id', Auth::User()->id)->exists()){
            UserPhotos::whereNull('deleted_at')->where('id', Auth::User()->id)->update(['deleted_at'=>Carbon::now()]);
        }else{

            if (isset($_FILES) && !empty($_FILES['request']['name']['file'])) {
                $user_id = Auth::User()->id;
                $dir_name =  $_SERVER['DOCUMENT_ROOT']."/storage"."/".$user_id."//";
                if (!is_dir($dir_name)) {
                    @mkdir($dir_name, "0777", true);
                }
                $current_timestamp  = Carbon::now()->timestamp;
                $photo_saved_name = $current_timestamp . $_FILES['request']['name']['file'];
                $photo_data_path = $dir_name.$photo_saved_name;
                $request->file->move($dir_name, $photo_saved_name);
                UserPhotos::whereNull('deleted_at')->where('id', Auth::User()->id)->insert(['user_id'=>$user_id,'photo_name' => $_FILES['request']['name']['file'],'path'=> $photo_data_path]);
            }else{
                new AppException("Something went wrong!");
            }
        }
    }
}
