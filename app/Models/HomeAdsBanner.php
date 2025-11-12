<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeAdsBanner extends Model
{
    use HasFactory , Crud, SoftDeletes;
    protected $fillable = [];
    public $table = 'home_ads_banners';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function store(){
        return $this->hasOne(Store::class , 'id' , 'store_id');
    }
    public function pages(){
        return $this->hasOne(BannerPageSetting::class , 'id' , 'page');
    }
}
