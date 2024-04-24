<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['content','parent_id','user_id'];
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id', 'id');
        }

        public function replies()
        {
            return $this->hasMany(Comment::class, 'parent_id');
        }

        public static function getAllComments()
        {
            return static::with('replies')->whereNull('parent_id')->get();
        }


}
