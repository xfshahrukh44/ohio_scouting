<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ListingImageService;
use App\Models\ListingImage;
use Storage;

class ListingImageController extends Controller
{
    private $listingService;
    private $listingImageService;

    public function __construct(ListingImageService $listingImageService)
    {
        $this->listingImageService = $listingImageService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(array_key_exists('listing_image_id', $_REQUEST)){
            $id = $_REQUEST['listing_image_id'];
        }

        // delete image from folder
        $listing_image = ListingImage::find($id);
        Storage::disk('public_listings')->delete($listing_image->location);

        return $this->listingImageService->delete($id);
    }
}
