<?php

namespace App\Services;

use App\Repositories\TestimonialRepository;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
// use Hash;

class TestimonialService extends TestimonialRepository
{
    public function toggle_testimonial_status($id)
    {
        if(!$testimonial = Testimonial::find($id)){
            return '';
        }

        $testimonial->status = (($testimonial->status == "Inactive") ? ("Active") : "Inactive");
        $testimonial->save();
        return '';
    }
}