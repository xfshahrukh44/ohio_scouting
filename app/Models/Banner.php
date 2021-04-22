<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'page',
        'title',
        'subtitle',
        'description',
        'status',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
