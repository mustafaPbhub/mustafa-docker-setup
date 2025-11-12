<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , Crud , SoftDeletes;
    protected $fillable = [];
    public $table ='products';
    public function __construct(array $attributes=[]){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function categories(){
        return $this->hasOne(ProductCategory::class,'id','category_id');
    }
    public function stores(){
        return $this->hasOne(Store::class,'id','store_id');
    }
    public function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
}
