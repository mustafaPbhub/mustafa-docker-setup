<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Coupon extends Model
{
    use HasFactory , SoftDeletes , Crud; 
    protected $fillable = [];
    public $table = 'coupons';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function stores(){
        return $this->hasOne(Store::class,'id' , 'store_id');
    }
}
