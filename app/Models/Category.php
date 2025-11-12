<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Crud;
    protected $fillable = [];
    public $table = 'categories';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class , 'category_id' , 'id');
    }
    public function stores(){
        return $this->hasMany(Store::class , 'category' , 'id');
    }
}
