<?php

namespace App\Services;

use App\Repositories\BannerRepository;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
// use Hash;

class BannerService extends BannerRepository
{
    public function toggle_banner_status($id)
    {
        if(!$banner = Banner::find($id)){
            return '';
        }

        $banner->status = (($banner->status == "Inactive") ? ("Active") : "Inactive");
        $banner->save();
        return '';
    }
}