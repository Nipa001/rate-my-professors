<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class EduPosts_User extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'edu_posts';
    protected $fillable = ['id', 'title', 'details', 'image', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
}
