<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'city',
        'location',
        'type',
        'price',
        'area',
        'bathrooms',
        'attach_bathrooms',
        'bedrooms',
        'purpose',
        'description',
        'status',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function listing_images()
    {
        return $this->hasMany('App\Models\ListingImage');
    }
}
