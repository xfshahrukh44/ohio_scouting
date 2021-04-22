<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BannerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class BannerController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
        $this->middleware('auth');
    }

    public function index()
    {
        $banners = $this->bannerService->paginate(env('PAGINATE'));
        return view('admin.banner.banner', compact('banners'));
    }

    public function all()
    {
        return $this->bannerService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required',
            'title' => 'sometimes',
            'subtitle' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // req
        $req = $request->all();

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        // create banner
        $banner = ($this->bannerService->create($req))['banner']['banner'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->bannerService->find($_REQUEST['id']);
        }
        return $this->bannerService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $banner = ($this->show($id))['banner'];

        $validator = Validator::make($request->all(), [
            'page' => 'sometimes',
            'title' => 'sometimes',
            'subtitle' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        // req
        $req = $request->all();

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $banner = ($this->bannerService->update($req, $id))['banner']['banner'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->bannerService->delete($id);

        return redirect()->back();
    }

    public function search_banners(Request $request)
    {
        $query = $request['query'];
        
        $banners = $this->bannerService->search_banners($query);

        return view('admin.banner.banner', compact('banners'));
    }
}