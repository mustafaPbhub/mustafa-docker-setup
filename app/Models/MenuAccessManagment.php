<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAccessManagment extends Model
{
    use HasFactory;
    use HasFactory , Crud;
    protected $fillable = [];
    public $table = 'menu_access_managments';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }

    public function submenu(){
        return $this->hasOne(SubMenu::class , 'id' , 'sub_menu_id');
    }
}
