<?php

namespace App\Models;

use App\Models\Traits\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostReply extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFiles;

    protected $fillable = [
        'user_id',
        'user_name',
        'floor',
        'content',
        'gps_latitude',
        'gps_longitude',
        'country',
        'city',
        'district',
        'street',
    ];
}
