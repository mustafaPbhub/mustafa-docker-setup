<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    protected $fillable =[];
    public $table = 'stores';
    public function __construct(array $attributes=[]){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    use HasFactory , SoftDeletes , Crud;
    public function headings(){
        return $this->hasOne(StoreHeading::class,'id' , 'heading');
    }
    public function categories(){
        return $this->hasOne(Category::class,'id' , 'category');
    }
    public function coupons(){
        return $this->hasMany(Coupon::class,'store_id' , 'id');
    }
    public function store_faqs(){
        return $this->hasMany(StoreFAQ::class,'store_id' , 'id');
    }
}
