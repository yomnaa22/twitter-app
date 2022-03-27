<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'description', 'tag', 'likes', 'retweets', 'img', 'Is_bookmarked', 'Is_liked', 'Is_retweeted'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
