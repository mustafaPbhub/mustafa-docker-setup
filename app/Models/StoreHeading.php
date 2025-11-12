<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreHeading extends Model
{
    use HasFactory ,  Crud;
    protected $fillable = [];
    public $table = 'store_headings';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
}
