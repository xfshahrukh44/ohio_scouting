<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CmsPageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class CmsPageController extends Controller
{
    private $cmsPageService;

    public function __construct(CmsPageService $cmsPageService)
    {
        $this->cmsPageService = $cmsPageService;
        $this->middleware('auth');
    }

    public function index()
    {
        $cms_pages = $this->cmsPageService->paginate(env('PAGINATE'));
        return view('admin.cms_page.cms_page', compact('cms_pages'));
    }

    public function all()
    {
        return $this->cmsPageService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'content' => 'sometimes',
            'content_2' => 'sometimes',
            'image' => 'sometimes',
            'status' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_cms_pages')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }


        // create cms_page
        $cms_page = ($this->cmsPageService->create($req))['cms_page']['cms_page'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->cmsPageService->find($_REQUEST['id']);
        }
        return $this->cmsPageService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $cms_page = ($this->show($id))['cms_page'];

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'title' => 'sometimes',
            'content' => 'sometimes',
            'content_2' => 'sometimes',
            'image' => 'sometimes',
            'status' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        // image work
        $req = Arr::except($request->all(),['image']);

        // image
        if($request->image){
            Storage::disk('public_cms_pages')->delete($cms_page->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_cms_pages')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $cms_page = ($this->cmsPageService->update($req, $id))['cms_page']['cms_page'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->cmsPageService->delete($id);

        return redirect()->back();
    }

    public function search_cms_pages(Request $request)
    {
        $query = $request['query'];
        
        $cms_pages = $this->cmsPageService->search_cms_pages($query);

        return view('admin.cms_page.cms_page', compact('cms_pages'));
    }

    public function toggle_cms_page_status(Request $request)
    {
        if(!(isset($request['id']))){
            return '';
        }
        return $this->cmsPageService->toggle_cms_page_status($request->id);
    }
}