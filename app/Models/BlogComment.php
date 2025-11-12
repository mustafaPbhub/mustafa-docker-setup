<?php

namespace App\Models;

use App\Models\ReplyComments;
use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory , Crud;
    protected $fillable = [];
    public $table = 'blog_comments';
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }

    public function replies(){
        return $this->hasMany(ReplyComments::class,'comment_id' , 'id');
    }
}