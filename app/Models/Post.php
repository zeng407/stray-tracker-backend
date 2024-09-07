<?php

namespace App\Models;

use App\Models\Traits\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasFiles;

    protected $fillable = [
        'user_id',
        'user_name',
        'title',
        'content',
        'gps_latitude',
        'gps_longitude',
        'country',
        'city',
        'district',
        'address',
    ];

    public function post_replies()
    {
        return $this->hasMany(PostReply::class);
    }
}
