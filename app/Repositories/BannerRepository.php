<?php

namespace App\Repositories;

use App\Exceptions\Banner\AllBannerException;
use App\Exceptions\Banner\CreateBannerException;
use App\Exceptions\Banner\UpdateBannerException;
use App\Exceptions\Banner\DeleteBannerException;
use App\Models\Banner;

abstract class BannerRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Banner $banner)
    {
        $this->model = $banner;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $banner = $this->model->create($data);
            
            return [
                'banner' => $this->find($banner->id)
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
                    'message' => 'Could`nt find banner',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'banner' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteBannerException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find banner',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'banner' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateBannerException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $banner = $this->model::find($id);
            if(!$banner)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find banner',
                ];
            }
            return [
                'success' => true,
                'banner' => $banner,
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
            throw new AllBannerException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllBannerException($exception->getMessage());
        }
    }

    public function search_banners($query)
    {
        // foreign fields

        // search block
        $banners = $this->model::where('page', 'LIKE', '%'.$query.'%')
                        ->orWhere('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('subtitle', 'LIKE', '%'.$query.'%')
                        ->orWhere('description', 'LIKE', '%'.$query.'%')
                        ->orWhere('status', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $banners;
    }
}