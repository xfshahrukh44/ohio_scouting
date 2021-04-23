<?php

namespace App\Repositories;

use App\Exceptions\Listing\AllListingException;
use App\Exceptions\Listing\CreateListingException;
use App\Exceptions\Listing\UpdateListingException;
use App\Exceptions\Listing\DeleteListingException;
use App\Models\Listing;

abstract class ListingRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Listing $listing)
    {
        $this->model = $listing;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $listing = $this->model->create($data);
            
            return [
                'listing' => $this->find($listing->id)
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
                    'message' => 'Could`nt find listing',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'listing' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteListingException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find listing',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'listing' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateListingException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $listing = $this->model::find($id);
            if(!$listing)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find listing',
                ];
            }
            return [
                'success' => true,
                'listing' => $listing,
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
            throw new AllListingException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllListingException($exception->getMessage());
        }
    }

    public function search_listings($query)
    {
        // foreign fields

        // search block
        $listings = $this->model::where('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('city', 'LIKE', '%'.$query.'%')
                        ->orWhere('location', 'LIKE', '%'.$query.'%')
                        ->orWhere('type', 'LIKE', '%'.$query.'%')
                        ->orWhere('price', 'LIKE', '%'.$query.'%')
                        ->orWhere('area', 'LIKE', '%'.$query.'%')
                        ->orWhere('purpose', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $listings;
    }
}