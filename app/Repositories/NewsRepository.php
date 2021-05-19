<?php

namespace App\Repositories;

use App\Exceptions\News\AllNewsException;
use App\Exceptions\News\CreateNewsException;
use App\Exceptions\News\UpdateNewsException;
use App\Exceptions\News\DeleteNewsException;
use App\Models\News;

abstract class NewsRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(News $news)
    {
        $this->model = $news;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $news = $this->model->create($data);
            
            return [
                'news' => $this->find($news->id)
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
                    'message' => 'Could`nt find news',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'news' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteNewsException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find news',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'news' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateNewsException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $news = $this->model::find($id);
            if(!$news)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find news',
                ];
            }
            return [
                'success' => true,
                'news' => $news,
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
            throw new AllNewsException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllNewsException($exception->getMessage());
        }
    }

    public function search_news($query)
    {
        // foreign fields

        // search block
        $news = $this->model::where('title', 'LIKE', '%'.$query.'%')
                        ->orWhere('type', 'LIKE', '%'.$query.'%')
                        ->orWhere('description', 'LIKE', '%'.$query.'%')
                        ->orWhere('date', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $news;
    }
}