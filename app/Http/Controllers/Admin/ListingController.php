<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ListingService;
use App\Services\ListingImageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{
    private $listingService;
    private $listingImageService;

    public function __construct(ListingService $listingService, ListingImageService $listingImageService)
    {
        $this->listingService = $listingService;
        $this->listingImageService = $listingImageService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $listings = $this->listingService->paginate(env('PAGINATE'));
        return view('admin.listing.listing', compact('listings'));
    }

    public function all()
    {
        return $this->listingService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'title' => 'required|string',
            'city' => 'required|string',
            'location' => 'required',
            'type' => 'required|string',
            'price' => 'required',
            'area' => 'required|int',
            'bathrooms' => 'required|int',
            'attach_bathrooms' => 'required|int',
            'bedrooms' => 'required|int',
            'purpose' => 'required|string',
            'description' => 'sometimes',
            'status' => 'required|string',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_listings')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $listing = ($this->listingService->create($req))['listing']['listing'];

        // listing_images (multiple)
        if($request->listing_images){
            $listing_images = [];
            foreach($request->listing_images as $listing_image){
                $image = $listing_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('public_listings')->put($imageName, \File::get($image));
                array_push($listing_images, $imageName);
            }
            foreach($listing_images as $listing_image){
                $this->listingImageService->create([
                    'listing_id' => $listing->id,
                    'location' => $listing_image,
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->listingService->find($_REQUEST['id']);
        }
        return $this->listingService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $listing = ($this->show($id))['listing'];

        $validator = Validator::make($request->all(), [
            'image' => 'sometimes',
            'title' => 'sometimes|string',
            'city' => 'sometimes|string',
            'location' => 'sometimes',
            'type' => 'sometimes|string',
            'price' => 'sometimes',
            'area' => 'sometimes|int',
            'bathrooms' => 'sometimes|int',
            'attach_bathrooms' => 'sometimes|int',
            'bedrooms' => 'sometimes|int',
            'purpose' => 'sometimes|string',
            'description' => 'sometimes',
            'status' => 'sometimes|string',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        // image work
        $req = Arr::except($request->all(),['image']);

        // image
        if($request->image){
            Storage::disk('public_listings')->delete($listing->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_listings')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        $listing = ($this->listingService->update($req, $id))['listing']['listing'];

        // listing_images (multiple)
        if($request->listing_images){
            $listing_images = [];
            foreach($request->listing_images as $listing_image){
                $image = $listing_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('public_listings')->put($imageName, \File::get($image));
                array_push($listing_images, $imageName);
            }
            foreach($listing_images as $listing_image){
                $this->listingImageService->create([
                    'listing_id' => $listing->id,
                    'location' => $listing_image,
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->listingService->delete($id);

        return redirect()->back();
    }

    public function search_listings(Request $request)
    {
        $query = $request['query'];
        
        $listings = $this->listingService->search_listings($query);

        return view('admin.listing.listing', compact('listings'));
    }
}