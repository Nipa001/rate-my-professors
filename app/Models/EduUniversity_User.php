<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EduUniversity_User extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'edu_universities';
    protected $fillable = ['id', 'varsity_name', 'district', 'country', 'address', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
}
