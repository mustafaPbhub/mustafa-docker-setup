<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreFAQ extends Model
{
    use HasFactory,  Crud, SoftDeletes;
    protected $fillable = [];
    public $table = 'store_f_a_q_s';
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
}
