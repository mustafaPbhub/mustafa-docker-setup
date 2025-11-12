<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderAdsBanner extends Model
{
    use HasFactory ,  Crud, SoftDeletes;
    protected $fillable = [];
    public $table = 'slider_ads_banners';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    use HasFactory;
    public function store(){
        return $this->hasOne(Store::class , 'id' , 'store_id');
    }

}
