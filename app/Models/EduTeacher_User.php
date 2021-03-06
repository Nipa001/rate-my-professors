<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class EduTeacher_User extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'edu_teachers';
    protected $fillable = ['id','teacher_id', 'name','address', 'email', 'phone','password','active_status','image','status', 'varsity_id', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
    // public static function boot()
    // {
    //     parent::studentBoot();
    // }
}
