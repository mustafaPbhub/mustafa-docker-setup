<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory , Crud;
    protected $fillable = [];
    public $table ='product_images';
    public function __construct(array $attributes=[]){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
}
