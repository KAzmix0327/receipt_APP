<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'body',
    ];

    protected $appends = [
        'user_name',
        'image_url',
    ];

    protected $hidden = [
        'image',
        'user_id',
        'updated_at',
        'user',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function entry()
    {
        return $this->hasOne(Entry::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function getImagePathAttribute()
    {
        return 'images/posts/' . $this->image;
    }
// API認証
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
