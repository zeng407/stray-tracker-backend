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
        'title',
        'content',
        'gps_latitude',
        'gps_longitude',
        'country',
        'city',
        'district',
        'street',
    ];
}
