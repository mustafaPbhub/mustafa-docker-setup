<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory , SoftDeletes , Crud;
    protected $fillable = [];
    public $table = 'blog_categories';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function blogs(){
        return $this->hasMany(Blog::class ,'category_id' , 'id');
    }
}
