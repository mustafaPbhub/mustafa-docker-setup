<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class WebsiteSetting extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function __construct(array $arrays = []){
        parent::__construct($arrays);
        $this->table = 'website_settings';
        $this->fillable =  Schema::getColumnListing($this->table);
    }

}
