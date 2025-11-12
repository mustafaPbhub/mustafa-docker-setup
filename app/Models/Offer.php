<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, Crud, SoftDeletes;
    protected $fillable = [];
    public $table = 'offers';
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
}
