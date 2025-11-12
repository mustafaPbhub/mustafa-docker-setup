<?php
namespace App\Trait;

use App\Models\Log;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use PgSql\Lob;

trait Crud{

    public static function columns($table = null){
        $columns = Schema::getColumnListing($table);
        return $columns;
    }
    public static function roles($route , $status){
        $checkAdmin  =  User::where(['id' => Auth::user()->id, 'role' => 1])->first();
        if (@$checkAdmin->role == 1) {
            return true;
        }
     
        $subMenuId   = SubMenu::where('route', $route)->first();
       
        if(!empty($subMenuId)){
           
            $checkAccess =  UserAccess::where(['sub_menu_id' => $subMenuId->id, $status => 1, 'role_id' => @Auth::user()->role])->first();
         
            if ($checkAccess) {
                return true;
            } else {
                return false;
            }
        }



    }
    public static function getMac(){
        return substr(exec('getmac'), 0, 17);
    }
    public function generateLog($message){
        $saveLog = Log::create(['description' => $message]);
        if($saveLog){return true;}
    }
    public static function store_logs($table, $subject,$description, $activity , $username = null){
        try{
            $saveLog =  Log::create([
                'user' => Auth::user()->name ?? $username,
                'short_description' => $subject,
                'description' => $description,
                'activity' => $activity,
                'table_name' => $table,
            ]);
            if($saveLog){
                return true;
            }
            else{
                return false;
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
