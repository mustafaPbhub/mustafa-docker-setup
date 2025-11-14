<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirection extends Model
{
    use HasFactory ,  Crud;
    protected $fillable = [
        'old_link',
        'new_link',
        'code',
        'type',
        'created_by',
        'updated_by'
    ];
    public $table = 'redirections';
    static public function check_url($route){
        $name            = "";
        $oldURL          = Redirection::where('old_link', url()->current())->first();

        if($oldURL){

          $name  = explode("/" , $oldURL->new_link);
          $name  = basename($oldURL->new_link);
          $route = route($route, $name);
          return ['route' => $route, 'statusCode' => $oldURL->code];
        }

    }
}
