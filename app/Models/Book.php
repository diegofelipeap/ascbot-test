<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers()
    {
    return $this->belongsToMany(User::class, 'book_user_favorites', 'book_id', 'user_id')->withTimestamps();
    }

}
