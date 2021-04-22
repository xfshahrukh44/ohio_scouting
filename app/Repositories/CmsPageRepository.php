<?php

namespace App\Repositories;

use App\Exceptions\CmsPage\AllCmsPageException;
use App\Exceptions\CmsPage\CreateCmsPageException;
use App\Exceptions\CmsPage\UpdateCmsPageException;
use App\Exceptions\CmsPage\DeleteCmsPageException;
use App\Models\CmsPage;

abstract class CmsPageRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(CmsPage $cms_page)
    {
        $this->model = $cms_page;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $cms_page = $this->model->create($data);
            
            return [
                'cms_page' => $this->find($cms_page->id)
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
                    'message' => 'Could`nt find cms_page',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'cms_page' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteCmsPageException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find cms_page',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'cms_page' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateCmsPageException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $cms_page = $this->model::find($id);
            if(!$cms_page)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find cms_page',
                ];
            }
            return [
                'success' => true,
                'cms_page' => $cms_page,
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
            throw new AllCmsPageException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllCmsPageException($exception->getMessage());
        }
    }

    public function search_cms_pages($query)
    {
        // foreign fields

        // search block
        $cms_pages = $this->model::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('status', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $cms_pages;
    }
}