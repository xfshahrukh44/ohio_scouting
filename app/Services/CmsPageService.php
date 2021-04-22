<?php

namespace App\Services;

use App\Repositories\CmsPageRepository;
use App\Models\CmsPage;
use Illuminate\Support\Facades\Auth;
// use Hash;

class CmsPageService extends CmsPageRepository
{
    public function toggle_cms_page_status($id)
    {
        if(!$cms_page = CmsPage::find($id)){
            return '';
        }

        $cms_page->status = (($cms_page->status == "Inactive") ? ("Active") : "Inactive");
        $cms_page->save();
        return '';
    }
}