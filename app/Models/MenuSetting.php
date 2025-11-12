<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{

    use HasFactory , Crud;
    protected $fillable = [];
    public $table = 'menu_settings';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function submenu(){
        return $this->hasMany(SubMenu::class , 'menu_id' , 'id');
    }
}
