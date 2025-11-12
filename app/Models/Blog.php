<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory , SoftDeletes , Crud;
    protected $fillable = [];
    public $table = 'blogs';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function categories()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
    }
    public function stores()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
    public function coupons(){
        return $this->hasMany(Coupon::class, 'store_id', 'store_id');
    }
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
}
