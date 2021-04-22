<?php

namespace App\Repositories;

use App\Exceptions\Testimonial\AllTestimonialException;
use App\Exceptions\Testimonial\CreateTestimonialException;
use App\Exceptions\Testimonial\UpdateTestimonialException;
use App\Exceptions\Testimonial\DeleteTestimonialException;
use App\Models\Testimonial;

abstract class TestimonialRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Testimonial $testimonial)
    {
        $this->model = $testimonial;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $testimonial = $this->model->create($data);
            
            return [
                'testimonial' => $this->find($testimonial->id)
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
                    'message' => 'Could`nt find testimonial',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'testimonial' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteTestimonialException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find testimonial',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'testimonial' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateTestimonialException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $testimonial = $this->model::find($id);
            if(!$testimonial)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find testimonial',
                ];
            }
            return [
                'success' => true,
                'testimonial' => $testimonial,
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
            throw new AllTestimonialException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllTestimonialException($exception->getMessage());
        }
    }
}