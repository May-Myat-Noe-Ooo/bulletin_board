<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'create_user_id',
        'updated_user_id',
        'deleted_user_id',
        'creatd_at',
        'updated_at',
        'deleted_at'
    ];
}
