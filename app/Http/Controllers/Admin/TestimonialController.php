<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TestimonialService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class TestimonialController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
        $this->middleware('auth');
    }

    public function index()
    {
        $testimonials = $this->testimonialService->paginate(env('PAGINATE'));
        return view('admin.testimonial.testimonial', compact('testimonials'));
    }

    public function all()
    {
        return $this->testimonialService->all();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'description' => 'sometimes',
            'image' => 'sometimes',
            'status' => 'sometimes',
        ]);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_testimonials')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }


        // create testimonial
        $testimonial = ($this->testimonialService->create($req))['testimonial']['testimonial'];

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->testimonialService->find($_REQUEST['id']);
        }
        return $this->testimonialService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $testimonial = ($this->show($id))['testimonial'];

        $request->validate([
            'name' => 'sometimes',
            'designation' => 'sometimes',
            'description' => 'sometimes',
            'image' => 'sometimes',
            'status' => 'sometimes',
        ]);

        
        // image work
        $req = Arr::except($request->all(),['image']);

        // image
        if($request->image){
            Storage::disk('public_testimonials')->delete($testimonial->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_testimonials')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $testimonial = ($this->testimonialService->update($req, $id))['testimonial']['testimonial'];
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->testimonialService->delete($id);

        return redirect()->back();
    }

    public function search_testimonials(Request $request)
    {
        $query = $request['query'];
        
        $testimonials = $this->testimonialService->search_testimonials($query);

        return view('admin.testimonial.testimonial', compact('testimonials'));
    }

    public function toggle_testimonial_status(Request $request)
    {
        if(!(isset($request['id']))){
            return '';
        }
        return $this->testimonialService->toggle_testimonial_status($request->id);
    }
}