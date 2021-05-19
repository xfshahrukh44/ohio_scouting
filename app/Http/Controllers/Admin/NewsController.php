<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NewsService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class NewsController extends Controller
{
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
        $this->middleware('auth');
    }

    public function index()
    {
        $news = $this->newsService->paginate(env('PAGINATE'));
        // dd($news);
        return view('admin.news.news', compact('news'));
    }

    public function all()
    {
        return $this->newsService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'sometimes',
            'type' => 'sometimes',
            'description' => 'sometimes',
            'date' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_news')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // create news
        $news = ($this->newsService->create($req))['news']['news'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->newsService->find($_REQUEST['id']);
        }
        return $this->newsService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $news = ($this->show($id))['news'];

        $request->validate([
            'title' => 'sometimes',
            'image' => 'sometimes',
            'type' => 'sometimes',
            'description' => 'sometimes',
            'date' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            Storage::disk('public_news')->delete($news->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_news')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $news = ($this->newsService->update($req, $id))['news']['news'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->newsService->delete($id);

        return redirect()->back();
    }

    public function search_news(Request $request)
    {
        $query = $request['query'];
        
        $news = $this->newsService->search_news($query);

        return view('admin.news.news', compact('news'));
    }
    
}