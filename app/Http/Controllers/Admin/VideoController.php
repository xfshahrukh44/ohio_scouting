<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VideoService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class VideoController extends Controller
{
    private $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = $this->videoService->paginate(env('PAGINATE'));
        return view('admin.video.video', compact('videos'));
    }

    public function all()
    {
        return $this->videoService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'sometimes',
            'type' => 'required',
            'link' => 'required',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_videos')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // create video
        $video = ($this->videoService->create($req))['video']['video'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->videoService->find($_REQUEST['id']);
        }
        return $this->videoService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $video = ($this->show($id))['video'];

        $request->validate([
            'title' => 'sometimes',
            'image' => 'sometimes',
            'type' => 'sometimes',
            'link' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            Storage::disk('public_videos')->delete($video->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_videos')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $video = ($this->videoService->update($req, $id))['video']['video'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->videoService->delete($id);

        return redirect()->back();
    }

    public function search_videos(Request $request)
    {
        $query = $request['query'];
        
        $videos = $this->videoService->search_videos($query);

        return view('admin.video.video', compact('videos'));
    }
    
}