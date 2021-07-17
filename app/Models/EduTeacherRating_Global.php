<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EduTeacherRating_Global extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'edu_teacher_ratings';
    protected $fillable = ['id','teacher_id', 'rating', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
}
