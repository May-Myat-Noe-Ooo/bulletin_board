<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'title', 'description', 'status', 'create_user_id', 'updated_user_id', 'deleted_user_id', 'created_at', 'updated_at', 'deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }
}
