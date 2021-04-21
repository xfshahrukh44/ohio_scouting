<?php

namespace App\Services;

use App\Repositories\LogoRepository;
use App\Models\Logo;
use Illuminate\Support\Facades\Auth;
// use Hash;

class LogoService extends LogoRepository
{
    public function get_main_logo()
    {
        return Logo::where('type', 'main')->first();
    }

    public function get_footer_logo()
    {
        return Logo::where('type', 'footer')->first();
    }

    public function get_favicon_logo()
    {
        return Logo::where('type', 'favicon')->first();
    }
}