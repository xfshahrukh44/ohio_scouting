<?php

namespace App\Repositories;

use App\Exceptions\ListingImage\AllListingImageException;
use App\Exceptions\ListingImage\CreateListingImageException;
use App\Exceptions\ListingImage\UpdateListingImageException;
use App\Exceptions\ListingImage\DeleteListingImageException;
use App\Models\ListingImage;

abstract class ListingImageRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(ListingImage $listing_image)
    {
        $this->model = $listing_image;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $listing_image = $this->model->create($data);
            
            return [
                'listing_image' => $this->find($listing_image->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find listing_image',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'listing_image' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteListingImageException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find listing_image',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'listing_image' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateListingImageException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $listing_image = $this->model::find($id);
            if(!$listing_image)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find listing_image',
                ];
            }
            return [
                'success' => true,
                'listing_image' => $listing_image,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllListingImageException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllListingImageException($exception->getMessage());
        }
    }
}