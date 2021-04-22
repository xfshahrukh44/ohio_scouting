<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'title',
        'content',
        'content_2',
        'image',
        'status',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
