<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EduTeacherComment_User extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'edu_teacher_comments';
    protected $fillable = ['id','teacher_id', 'comment', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
    public static function boot()
    {
        parent::studentBoot();
    }
}
