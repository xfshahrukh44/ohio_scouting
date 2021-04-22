<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
// use Hash;

class SettingService extends SettingRepository
{
    public function get_by_key($key)
    {
        return Setting::where('key', $key)->first();
    }
}