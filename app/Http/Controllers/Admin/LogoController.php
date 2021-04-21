<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogoService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class LogoController extends Controller
{
    private $logoService;

    public function __construct(LogoService $logoService)
    {
        $this->logoService = $logoService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $main_logo = $this->logoService->get_main_logo();
        $footer_logo = $this->logoService->get_footer_logo();
        $favicon_logo = $this->logoService->get_favicon_logo();

        return view('admin.logo.logo_settings', compact('main_logo', 'footer_logo', 'favicon_logo'));
    }
    
    public function store(Request $request)
    {
        // if main_logo provided
        if($request->main_logo){
            // if logo record of type main is not present create one
            if(!$main_logo = $this->logoService->get_main_logo()){
                $main_logo = ($this->logoService->create(['type' => 'main']))['logo']['logo'];
            }

            // delete old
            Storage::disk('public_logos')->delete($main_logo->image);

            // create new
            $image = $request->main_logo;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_logos')->put($imageName, \File::get($image));
            $main_logo['image'] = $imageName;
            $main_logo->save();
        }

        // if footer_logo provided
        if($request->footer_logo){
            // if logo record of type footer is not present create one
            if(!$footer_logo = $this->logoService->get_footer_logo()){
                $footer_logo = ($this->logoService->create(['type' => 'footer']))['logo']['logo'];
            }

            // delete old
            Storage::disk('public_logos')->delete($footer_logo->image);

            // create new
            $image = $request->footer_logo;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_logos')->put($imageName, \File::get($image));
            $footer_logo['image'] = $imageName;
            $footer_logo->save();
        }

        // if favicon_logo provided
        if($request->favicon_logo){
            // if logo record of type favicon is not present create one
            if(!$favicon_logo = $this->logoService->get_favicon_logo()){
                $favicon_logo = ($this->logoService->create(['type' => 'favicon']))['logo']['logo'];
            }

            // delete old
            Storage::disk('public_logos')->delete($favicon_logo->image);

            // create new
            $image = $request->favicon_logo;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_logos')->put($imageName, \File::get($image));
            $favicon_logo['image'] = $imageName;
            $favicon_logo->save();
        }

        return redirect()->route('logo.index');
    }
    
    public function show($id)
    {
        
    }
    
    public function update(Request $request, $id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }

    public function fetch_settings()
    {

    }
}
